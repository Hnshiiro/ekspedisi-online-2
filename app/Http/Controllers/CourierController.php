<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\ShipmentTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourierController extends Controller
{
    public function dashboard()
    {
        $user = Auth::guard('web')->user();
        return view('courier.dashboard', [
            'user'              => $user,
            'assignedShipments' => Shipment::with(['sender','receiver','originBranch','destinationBranch'])
                ->where('courier_id', $user->id)
                ->whereNotIn('status', ['delivered','cancelled'])
                ->orderByDesc('created_at')->get(),
            'deliveredToday'    => Shipment::where('courier_id', $user->id)
                ->where('status','delivered')->whereDate('delivered_at', today())->count(),
            'totalDelivered'    => Shipment::where('courier_id', $user->id)->where('status','delivered')->count(),
        ]);
    }

    public function shipments()
    {
        $user = Auth::guard('web')->user();
        $shipments = Shipment::with(['sender','receiver','originBranch','destinationBranch'])
            ->where('courier_id', $user->id)
            ->orderByDesc('created_at')->paginate(15);
        return view('courier.shipments', compact('shipments'));
    }

    public function updateStatus(Request $request, Shipment $shipment)
    {
        $user = Auth::guard('web')->user();
        if ($shipment->courier_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status'      => 'required|in:picked_up,in_transit,arrived_at_branch,out_for_delivery,delivered',
            'location'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $update = ['status' => $validated['status']];
        if ($validated['status'] === 'delivered') {
            $update['delivered_at'] = now();
        }
        $shipment->update($update);

        ShipmentTracking::create([
            'shipment_id' => $shipment->id,
            'recorded_by' => $user->id,
            'status'      => $validated['status'],
            'location'    => $validated['location'] ?? null,
            'description' => $validated['description'] ?? null,
            'checked_at'  => now(),
        ]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }
}
