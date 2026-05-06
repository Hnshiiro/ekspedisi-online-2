<?php

namespace App\Http\Controllers;

use App\Models\ShippingRoute;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = ShippingRoute::withCount('shipments')->orderBy('origin_city')->paginate(15);
        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        return view('admin.routes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'origin_city'      => 'required|string|max:100',
            'destination_city' => 'required|string|max:100',
            'price_per_kg'     => 'required|numeric|min:0',
            'estimated_days'   => 'required|integer|min:1|max:30',
        ]);
        ShippingRoute::create($validated);
        return redirect()->route('admin.routes.index')->with('success', 'Rute berhasil ditambahkan.');
    }

    public function edit(ShippingRoute $route)
    {
        return view('admin.routes.edit', compact('route'));
    }

    public function update(Request $request, ShippingRoute $route)
    {
        $validated = $request->validate([
            'origin_city'      => 'required|string|max:100',
            'destination_city' => 'required|string|max:100',
            'price_per_kg'     => 'required|numeric|min:0',
            'estimated_days'   => 'required|integer|min:1|max:30',
        ]);
        $route->update($validated);
        return redirect()->route('admin.routes.index')->with('success', 'Rute berhasil diperbarui.');
    }

    public function destroy(ShippingRoute $route)
    {
        $route->delete();
        return redirect()->route('admin.routes.index')->with('success', 'Rute berhasil dihapus.');
    }
}
