<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPortalController extends Controller
{
    public function dashboard()
    {
        $customer = Auth::guard('customer')->user();
        $myShipments = Shipment::with(['service','originBranch','destinationBranch'])
            ->where(fn($q) => $q->where('sender_id', $customer->id)->orWhere('receiver_id', $customer->id))
            ->orderByDesc('created_at')->limit(5)->get();

        return view('customer.dashboard', [
            'customer'      => $customer,
            'myShipments'   => $myShipments,
            'totalSent'     => Shipment::where('sender_id', $customer->id)->count(),
            'totalReceived' => Shipment::where('receiver_id', $customer->id)->count(),
            'inProgress'    => Shipment::where(fn($q) => $q->where('sender_id', $customer->id)->orWhere('receiver_id', $customer->id))
                ->whereNotIn('status',['delivered','cancelled'])->count(),
        ]);
    }

    public function shipments(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        $query = Shipment::with(['service','originBranch','destinationBranch'])
            ->where(fn($q) => $q->where('sender_id', $customer->id)->orWhere('receiver_id', $customer->id));
        if ($request->filled('status')) $query->where('status', $request->status);
        $shipments = $query->orderByDesc('created_at')->paginate(10)->withQueryString();
        $statuses  = array_keys(Shipment::statusLabels());
        return view('customer.shipments', compact('shipments','statuses'));
    }

    public function createShipment()
    {
        $services = \App\Models\Service::all();
        $routes = \App\Models\ShippingRoute::select('destination_city')->distinct()->pluck('destination_city');
        $branches = \App\Models\Branch::where('is_active', true)->get();
        return view('customer.create-shipment', compact('services', 'routes', 'branches'));
    }

    public function storeShipment(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        
        $request->validate([
            'receiver_name'    => 'required|string|max:255',
            'receiver_phone'   => 'required|string|max:30',
            'destination_city' => 'required|string|max:100',
            'receiver_address' => 'required|string',
            'service_id'       => 'required|exists:services,id',
            'origin_branch_id' => 'required|exists:branches,id',
            'payment_method'   => 'required|in:midtrans',
            'sender_name'      => 'required|string|max:255',
            'sender_phone'     => 'required|string|max:30',
            'item_name'        => 'required|string',
            'weight'           => 'required|numeric|min:0.1',
        ]);

        $service = \App\Models\Service::find($request->service_id);
        
        // Coba cari rute untuk menentukan harga (asumsi pengirim dari kota customer)
        $route = \App\Models\ShippingRoute::where('origin_city', 'like', '%'.$customer->city.'%')
                    ->where('destination_city', 'like', '%'.$request->destination_city.'%')->first();
        
        $basePrice = $route ? ($route->price_per_kg * $request->weight) : (10000 * $request->weight); // default 10k/kg jika rute tdk ada
        $totalPrice = $basePrice * $service->price_multiplier;

        // Tentukan destination branch (cari berdasarkan kota tujuan, jika tidak ada gunakan origin)
        $destBranch = \App\Models\Branch::where('city', 'like', '%'.$request->destination_city.'%')->first();
        $destinationBranchId = $destBranch ? $destBranch->id : $request->origin_branch_id;

        $shipment = Shipment::create([
            'tracking_number'  => 'SPX' . strtoupper(uniqid()),
            'sender_id'        => $customer->id,
            'sender_name'      => $request->sender_name,
            'sender_phone'     => $request->sender_phone,
            'sender_address'   => $customer->address,
            'origin_city'      => $customer->city,
            'origin_branch_id' => $request->origin_branch_id,
            'destination_branch_id' => $destinationBranchId,
            'receiver_id'      => null,
            'receiver_name'    => $request->receiver_name,
            'receiver_phone'   => $request->receiver_phone,
            'receiver_address' => $request->receiver_address,
            'destination_city' => $request->destination_city,
            'service_id'       => $service->id,
            'total_weight'     => $request->weight,
            'total_price'      => $totalPrice,
            'status'           => 'pending',
            'payment_status'   => 'unpaid',
            'shipment_date'    => now(),
        ]);

        $shipment->items()->create([
            'item_name' => $request->item_name,
            'quantity'  => 1,
            'weight'    => $request->weight,
        ]);

        $shipment->trackings()->create([
            'status'      => 'pending',
            'description' => 'Permintaan penjemputan paket dibuat oleh pengirim.',
            'checked_at'  => now(),
        ]);

        $payment = $shipment->payments()->create([
            'amount' => $totalPrice,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'payment_number' => 'PAY-' . strtoupper(uniqid()),
            'payment_date' => now(),
        ]);

        if ($request->payment_method === 'midtrans') {
            \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            // Gunakan suffix unik agar bisa retry pembayaran jika sebelumnya gagal/expired
            $orderId = $shipment->tracking_number . '-' . time();

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int)$totalPrice,
                ],
                'customer_details' => [
                    'first_name' => $shipment->sender_name ?? $customer->name,
                    'email' => $customer->email,
                    'phone' => $shipment->sender_phone ?? $customer->phone,
                ],
                // Opsional: aktifkan semua metode pembayaran
                'enabled_payments' => ['credit_card', 'gopay', 'shopeepay', 'permata_va', 'bca_va', 'bni_va', 'bri_va', 'other_va', 'danamon_online', 'akulaku', 'kredivo', 'alfamart', 'indomaret', 'qris'],
            ];

            try {
                $midtransTransaction = \Midtrans\Snap::createTransaction($params);
                $snapToken = $midtransTransaction->token;
                $paymentUrl = $midtransTransaction->redirect_url;
                
                $shipment->update([
                    'snap_token' => $snapToken,
                    'payment_url' => $paymentUrl
                ]);
                return redirect()->route('customer.shipments')->with('success', 'Berhasil membuat permintaan pengiriman. Silakan selesaikan pembayaran.')->with('pay_snap_token', $snapToken);
            } catch (\Exception $e) {
                return redirect()->route('customer.shipments')->with('error', 'Gagal Midtrans: ' . $e->getMessage());
            }
        }

        return redirect()->route('customer.shipments')->with('success', 'Berhasil membuat permintaan pengiriman paket. Kurir kami akan segera mengambil paket Anda.');
    }

    public function payShipment(Shipment $shipment)
    {
        $customer = Auth::guard('customer')->user();
        
        // Pastikan shipment milik customer ini dan belum dibayar
        if (($shipment->sender_id !== $customer->id && $shipment->receiver_id !== $customer->id) || $shipment->payment_status === 'paid') {
            return response()->json(['error' => 'Transaksi tidak valid atau sudah dibayar.'], 403);
        }

        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $orderId = $shipment->tracking_number . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int)$shipment->total_price,
            ],
            'customer_details' => [
                'first_name' => $shipment->sender_name ?? $customer->name,
                'email' => $customer->email,
                'phone' => $shipment->sender_phone ?? $customer->phone,
            ],
            'enabled_payments' => ['credit_card', 'gopay', 'shopeepay', 'permata_va', 'bca_va', 'bni_va', 'bri_va', 'other_va', 'danamon_online', 'akulaku', 'kredivo', 'alfamart', 'indomaret', 'qris'],
        ];

        try {
            $midtransTransaction = \Midtrans\Snap::createTransaction($params);
            $snapToken = $midtransTransaction->token;
            $paymentUrl = $midtransTransaction->redirect_url;
            
            $shipment->update([
                'snap_token' => $snapToken,
                'payment_url' => $paymentUrl
            ]);

            return response()->json([
                'snap_token' => $snapToken,
                'payment_url' => $paymentUrl
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function track(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        $trackingNumber = trim($request->query('no',''));
        $shipment = null;

        if ($trackingNumber) {
            $shipment = Shipment::with([
                'sender','receiver','originBranch','destinationBranch',
                'service','courier',
                'trackings' => fn($q) => $q->orderByDesc('checked_at'),
            ])->where('tracking_number', $trackingNumber)
              ->where(fn($q) => $q->where('sender_id', $customer->id)->orWhere('receiver_id', $customer->id))
              ->first();
        }

        return view('customer.track', compact('trackingNumber','shipment'));
    }

    public function profile()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer.profile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'city'    => 'nullable|string|max:100',
            'photo'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($customer->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($customer->photo);
            }
            $path = $request->file('photo')->store('profiles/customers', 'public');
            $validated['photo'] = $path;
        }

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $validated['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $customer->update($validated);
        return redirect()->route('customer.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
