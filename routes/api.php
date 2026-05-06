<?php

use App\Models\Shipment;
use App\Models\ShippingRoute;
use App\Models\Branch;
use App\Models\Service;
use Illuminate\Support\Facades\Route;

Route::get('/ping', fn() => response()->json(['status' => 'ok', 'time' => now()]));

Route::prefix('v1')->group(function () {
    // Public tracking
    Route::get('/track/{tracking_number}', function ($tn) {
        $s = Shipment::with(['sender','originBranch','destinationBranch','service','trackings'])
            ->where('tracking_number', $tn)->first();
        if (!$s) return response()->json(['status' => 'error', 'message' => 'Tidak ditemukan'], 404);
        return response()->json(['status' => 'success', 'data' => $s]);
    });

    // Ongkir calculator
    Route::get('/ongkir', function () {
        $routes   = ShippingRoute::all();
        $services = Service::all();
        return response()->json(['status' => 'success', 'routes' => $routes, 'services' => $services]);
    });

    // Branches
    Route::get('/branches', function () {
        return response()->json(['status' => 'success', 'data' => Branch::where('is_active', true)->get()]);
    });
});

Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransController::class, 'notificationHandler']);