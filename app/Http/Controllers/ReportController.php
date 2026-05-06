<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year  = $request->input('year', now()->year);

        $shipmentsByStatus = Shipment::selectRaw('status, count(*) as total')
            ->whereMonth('created_at', $month)->whereYear('created_at', $year)
            ->groupBy('status')->pluck('total', 'status');

        $revenueByMonth = Payment::selectRaw('MONTH(payment_date) as month, SUM(amount) as total')
            ->where('payment_status', 'paid')->whereYear('payment_date', $year)
            ->groupBy('month')->pluck('total', 'month');

        $topBranches = \App\Models\Branch::withCount('shipments')
            ->orderByDesc('shipments_count')->limit(5)->get();

        return view('admin.reports.index', compact('shipmentsByStatus','revenueByMonth','topBranches','month','year'));
    }
}
