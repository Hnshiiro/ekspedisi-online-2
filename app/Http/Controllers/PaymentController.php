<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['shipment.sender','receiver']);
        if ($request->filled('payment_status')) $query->where('payment_status', $request->payment_status);
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn($sq) => $sq->where('payment_number','like',"%$q%")
                ->orWhereHas('shipment', fn($sq2) => $sq2->where('tracking_number','like',"%$q%")));
        }
        $payments = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        return view('admin.payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $shipments = Shipment::whereIn('payment_status', ['unpaid','partial'])
            ->with('sender')->orderByDesc('created_at')->get();
        $selectedShipment = $request->filled('shipment_id')
            ? Shipment::with('sender')->find($request->shipment_id) : null;
        return view('admin.payments.create', compact('shipments','selectedShipment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipment_id'    => 'required|exists:shipments,id',
            'amount'         => 'required|numeric|min:1',
            'payment_method' => 'required|in:cash,bank_transfer,e_wallet',
            'payment_date'   => 'required|date',
            'notes'          => 'nullable|string',
        ]);

        $validated['payment_number'] = 'PAY-' . strtoupper(uniqid());
        $validated['payment_status'] = 'paid';
        $validated['received_by']    = Auth::guard('web')->id();

        $payment  = Payment::create($validated);
        $shipment = $payment->shipment;
        $paidTotal = $shipment->payments()->where('payment_status','paid')->sum('amount');

        if ($paidTotal >= $shipment->total_price) {
            $shipment->update(['payment_status' => 'paid']);
        } else {
            $shipment->update(['payment_status' => 'partial']);
        }

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function show(Payment $payment)
    {
        $payment->load(['shipment.sender','shipment.receiver','receiver']);
        return view('admin.payments.show', compact('payment'));
    }

    public function markAsPaid(Payment $payment)
    {
        if ($payment->payment_status !== 'pending') {
            return back()->with('error', 'Hanya pembayaran pending yang bisa dikonfirmasi.');
        }

        $payment->update([
            'payment_status' => 'paid',
            'payment_date' => now(),
            'received_by' => Auth::guard('web')->id(),
            'notes' => ($payment->notes ? $payment->notes . ' | ' : '') . 'Dikonfirmasi manual oleh admin'
        ]);

        $shipment = $payment->shipment;
        if ($shipment) {
            $paidTotal = $shipment->payments()->where('payment_status', 'paid')->sum('amount');
            if ($paidTotal >= $shipment->total_price) {
                $shipment->update(['payment_status' => 'paid']);
            } else {
                $shipment->update(['payment_status' => 'partial']);
            }
        }

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi secara manual.');
    }
}
