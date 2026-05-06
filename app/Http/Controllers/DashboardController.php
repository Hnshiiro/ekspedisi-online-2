<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Shipment;
use App\Models\ShippingRoute;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        return view('admin.dashboard', $this->adminMetrics());
    }

    public function branchDashboard()
    {
        $user = Auth::guard('web')->user();
        $branchId = $user->branch_id;
        return view('branch.dashboard', [
            'branch'         => $user->branch,
            'totalShipments' => Shipment::where('origin_branch_id', $branchId)->count(),
            'pendingShipments' => Shipment::where('origin_branch_id', $branchId)->where('status', 'pending')->count(),
            'inTransitShipments' => Shipment::where('origin_branch_id', $branchId)->whereIn('status', ['picked_up','in_transit'])->count(),
            'deliveredShipments' => Shipment::where('origin_branch_id', $branchId)->where('status', 'delivered')->count(),
            'recentShipments' => Shipment::with(['sender','service'])
                ->where('origin_branch_id', $branchId)
                ->orderByDesc('created_at')->limit(8)->get(),
            'vehicles'       => Vehicle::where('branch_id', $branchId)->get(),
            'couriers'       => User::where('branch_id', $branchId)->where('role', 'courier')->where('is_active', true)->get(),
        ]);
    }

    public function courierDashboard()
    {
        $user = Auth::guard('web')->user();
        return view('courier.dashboard', [
            'user'              => $user,
            'assignedShipments' => Shipment::with(['sender','receiver','originBranch','destinationBranch'])
                ->where('courier_id', $user->id)
                ->whereNotIn('status', ['delivered','cancelled'])
                ->orderByDesc('created_at')->get(),
            'deliveredToday'    => Shipment::where('courier_id', $user->id)
                ->where('status', 'delivered')
                ->whereDate('delivered_at', today())->count(),
            'totalDelivered'    => Shipment::where('courier_id', $user->id)->where('status', 'delivered')->count(),
        ]);
    }

    public function managerDashboard()
    {
        return view('manager.dashboard', array_merge($this->adminMetrics(), [
            'revenueTotal'  => Payment::where('payment_status', 'paid')->sum('amount'),
            'revenueMonth'  => Payment::where('payment_status', 'paid')->whereMonth('payment_date', now()->month)->sum('amount'),
            'shipmentsByStatus' => Shipment::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
        ]));
    }

    private function adminMetrics(): array
    {
        return [
            'totalBranches'      => Branch::count(),
            'totalCustomers'     => Customer::count(),
            'totalVehicles'      => Vehicle::count(),
            'totalUsers'         => User::count(),
            'totalShipments'     => Shipment::count(),
            'pendingShipments'   => Shipment::where('status', 'pending')->count(),
            'inTransitShipments' => Shipment::whereIn('status', ['picked_up','in_transit','arrived_at_branch','out_for_delivery'])->count(),
            'deliveredShipments' => Shipment::where('status', 'delivered')->count(),
            'cancelledShipments' => Shipment::where('status', 'cancelled')->count(),
            'totalRevenue'       => Payment::where('payment_status', 'paid')->sum('amount'),
            'recentShipments'    => Shipment::with(['sender','service','originBranch'])->orderByDesc('created_at')->limit(8)->get(),
            'recentPayments'     => Payment::with('shipment')->orderByDesc('created_at')->limit(5)->get(),
        ];
    }
}
