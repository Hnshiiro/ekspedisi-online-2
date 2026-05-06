<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Shipment;
use App\Models\ShippingRoute;
use App\Models\ShipmentTracking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $trackingNumber = trim((string) $request->query('tracking_number', ''));
        $trackedShipment = null;

        if ($trackingNumber !== '') {
            $trackedShipment = Shipment::with([
                'sender', 'receiver', 'originBranch', 'destinationBranch',
                'service', 'courier',
                'trackings' => fn($q) => $q->orderByDesc('checked_at'),
            ])->where('tracking_number', $trackingNumber)->first();
        }

        return view('home', [
            'trackingNumber'     => $trackingNumber,
            'trackedShipment'    => $trackedShipment,
            'totalShipments'     => Shipment::count(),
            'deliveredShipments' => Shipment::where('status', 'delivered')->count(),
            'activeBranches'     => Branch::where('is_active', true)->count(),
            'totalCustomers'     => Customer::count(),
            'services'           => Service::all(),
            'recentShipments'    => Shipment::with(['sender','service'])->orderByDesc('created_at')->limit(6)->get(),
        ]);
    }

    public function trackPage(Request $request)
    {
        $trackingNumber = trim((string) $request->query('no', ''));
        $trackedShipment = null;

        if ($trackingNumber !== '') {
            $trackedShipment = Shipment::with([
                'sender', 'receiver', 'originBranch', 'destinationBranch',
                'service', 'courier',
                'trackings' => fn($q) => $q->orderByDesc('checked_at'),
            ])->where('tracking_number', $trackingNumber)->first();
        }

        return view('tracking', compact('trackingNumber', 'trackedShipment'));
    }

    public function cekOngkir(Request $request)
    {
        $result = null;
        if ($request->isMethod('post')) {
            $request->validate([
                'origin'     => 'required|string',
                'destination'=> 'required|string',
                'weight'     => 'required|numeric|min:0.1',
                'service_id' => 'required|exists:services,id',
            ]);

            $route = ShippingRoute::where('origin_city', 'like', '%'.$request->origin.'%')
                ->where('destination_city', 'like', '%'.$request->destination.'%')->first();
            $service = Service::find($request->service_id);

            if ($route && $service) {
                $base = $route->price_per_kg * $request->weight;
                $result = [
                    'route'           => $route,
                    'service'         => $service,
                    'weight'          => $request->weight,
                    'base_price'      => $base,
                    'final_price'     => $base * $service->price_multiplier,
                    'estimated_days'  => $route->estimated_days,
                ];
            }
        }

        $services = Service::all();
        $routes   = ShippingRoute::select('origin_city')->distinct()->pluck('origin_city');
        return view('cek-ongkir', compact('result', 'services', 'routes'));
    }
}
