<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\ShipmentTracking;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Branch;
use App\Models\Service;
use App\Models\ShippingRoute;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    public function index(Request $request)
    {
        $user  = Auth::guard('web')->user();
        $query = Shipment::with(['sender','receiver','originBranch','service','courier']);

        // Branch admin only sees their branch's shipments
        if ($user->role === 'branch_admin' && $user->branch_id) {
            $query->where('origin_branch_id', $user->branch_id);
        }
        // Courier only sees their assigned shipments
        if ($user->role === 'courier') {
            $query->where('courier_id', $user->id);
        }

        if ($request->filled('status'))      $query->where('status', $request->status);
        if ($request->filled('branch_id'))   $query->where('origin_branch_id', $request->branch_id);
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn($sq) => $sq->where('tracking_number','like',"%$q%")
                ->orWhereHas('sender', fn($sq2) => $sq2->where('name','like',"%$q%")));
        }

        $shipments = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $branches  = Branch::where('is_active', true)->get();
        $statuses  = array_keys(Shipment::statusLabels());

        return view('admin.shipments.index', compact('shipments','branches','statuses'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $vehicles  = Vehicle::where('status', 'available')->get();
        $branches  = Branch::where('is_active', true)->get();
        $services  = Service::all();
        $routes    = ShippingRoute::all();
        $couriers  = User::where('role', 'courier')->where('is_active', true)->get();
        return view('admin.shipments.create', compact('customers','vehicles','branches','services','routes','couriers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender_id'               => 'required|exists:customers,id',
            'receiver_id'             => 'required|exists:customers,id|different:sender_id',
            'origin_branch_id'        => 'required|exists:branches,id',
            'destination_branch_id'   => 'required|exists:branches,id',
            'vehicle_id'              => 'nullable|exists:vehicles,id',
            'courier_id'              => 'nullable|exists:users,id',
            'service_id'              => 'required|exists:services,id',
            'route_id'                => 'nullable|exists:routes,id',
            'origin_city'             => 'required|string|max:100',
            'destination_city'        => 'required|string|max:100',
            'sender_address'          => 'required|string',
            'receiver_address'        => 'required|string',
            'description'             => 'nullable|string',
            'total_weight'            => 'required|numeric|min:0.1',
            'total_price'             => 'required|numeric|min:0',
            'shipment_date'           => 'required|date',
            'estimated_delivery_date' => 'nullable|date|after_or_equal:shipment_date',
            'notes'                   => 'nullable|string',
            'items'                   => 'nullable|array',
            'items.*.item_name'       => 'required_with:items|string',
            'items.*.quantity'        => 'required_with:items|integer|min:1',
            'items.*.weight'          => 'required_with:items|numeric|min:0',
        ]);

        $validated['tracking_number'] = 'EKS-' . strtoupper(uniqid());
        $validated['created_by']      = Auth::guard('web')->id();
        $validated['status']          = 'pending';
        $validated['payment_status']  = 'unpaid';

        $shipment = Shipment::create($validated);

        // Items
        if (!empty($request->items)) {
            foreach ($request->items as $item) {
                if (!empty($item['item_name'])) {
                    $shipment->items()->create($item);
                }
            }
        }

        // Initial tracking
        ShipmentTracking::create([
            'shipment_id' => $shipment->id,
            'recorded_by' => Auth::guard('web')->id(),
            'status'      => 'pending',
            'location'    => $shipment->originBranch->city ?? $shipment->origin_city,
            'description' => 'Pengiriman baru dibuat.',
            'checked_at'  => now(),
        ]);

        return redirect()->route('admin.shipments.show', $shipment)
            ->with('success', 'Pengiriman berhasil dibuat. No. Resi: '.$shipment->tracking_number);
    }

    public function show(Shipment $shipment)
    {
        $shipment->load(['sender','receiver','originBranch','destinationBranch',
            'vehicle','courier','service','creator','items',
            'trackings.recorder','payments.receiver']);
        return view('admin.shipments.show', compact('shipment'));
    }

    public function edit(Shipment $shipment)
    {
        if (!in_array($shipment->status, ['pending','picked_up'])) {
            return redirect()->route('admin.shipments.show', $shipment)
                ->with('error', 'Pengiriman yang sudah diproses tidak dapat diubah.');
        }
        $customers = Customer::orderBy('name')->get();
        $vehicles  = Vehicle::where('status', 'available')->orWhere('id', $shipment->vehicle_id)->get();
        $branches  = Branch::where('is_active', true)->get();
        $services  = Service::all();
        $routes    = ShippingRoute::all();
        $couriers  = User::where('role', 'courier')->where('is_active', true)->get();
        return view('admin.shipments.edit', compact('shipment','customers','vehicles','branches','services','routes','couriers'));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'vehicle_id'              => 'nullable|exists:vehicles,id',
            'courier_id'              => 'nullable|exists:users,id',
            'service_id'              => 'required|exists:services,id',
            'destination_city'        => 'required|string|max:100',
            'receiver_address'        => 'required|string',
            'total_weight'            => 'required|numeric|min:0.1',
            'total_price'             => 'required|numeric|min:0',
            'estimated_delivery_date' => 'nullable|date',
            'notes'                   => 'nullable|string',
        ]);

        $shipment->update($validated);
        return redirect()->route('admin.shipments.show', $shipment)->with('success', 'Pengiriman berhasil diperbarui.');
    }

    public function destroy(Shipment $shipment)
    {
        if ($shipment->status !== 'pending') {
            return redirect()->route('admin.shipments.index')
                ->with('error', 'Hanya pengiriman pending yang dapat dihapus.');
        }
        $shipment->delete();
        return redirect()->route('admin.shipments.index')->with('success', 'Pengiriman berhasil dihapus.');
    }

    public function updateStatus(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'status'      => 'required|in:picked_up,in_transit,arrived_at_branch,out_for_delivery,delivered,cancelled',
            'location'    => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $update = ['status' => $validated['status']];
        if ($validated['status'] === 'delivered') {
            $update['delivered_at'] = now();
        }

        $shipment->update($update);

        ShipmentTracking::create([
            'shipment_id' => $shipment->id,
            'recorded_by' => Auth::guard('web')->id(),
            'status'      => $validated['status'],
            'location'    => $validated['location'] ?? null,
            'description' => $validated['description'] ?? null,
            'checked_at'  => now(),
        ]);

        return redirect()->route('admin.shipments.show', $shipment)
            ->with('success', 'Status pengiriman berhasil diperbarui.');
    }

    public function assign(Request $request, Shipment $shipment)
    {
        $request->validate([
            'courier_id' => 'required|exists:users,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
        ]);

        $shipment->update([
            'courier_id' => $request->courier_id,
            'vehicle_id' => $request->vehicle_id,
            'status'     => 'picked_up', // Otomatis ubah status saat ditugaskan
        ]);

        ShipmentTracking::create([
            'shipment_id' => $shipment->id,
            'recorded_by' => Auth::guard('web')->id(),
            'status'      => 'picked_up',
            'location'    => $shipment->originBranch->name ?? 'Cabang Asal',
            'description' => 'Paket telah ditugaskan ke kurir ' . $shipment->courier->name . '.',
            'checked_at'  => now(),
        ]);

        return back()->with('success', 'Paket berhasil ditugaskan ke ' . $shipment->courier->name);
    }
}
