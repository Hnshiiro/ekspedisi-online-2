<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Branch;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('branch')->orderBy('plate_number')->paginate(15);
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        return view('admin.vehicles.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id'    => 'nullable|exists:branches,id',
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number',
            'brand'        => 'nullable|string|max:100',
            'type'         => 'required|in:truck,van,motorcycle',
            'capacity_kg'  => 'required|numeric|min:0',
            'driver_name'  => 'nullable|string|max:255',
            'status'       => 'required|in:available,in_use,maintenance',
        ]);
        Vehicle::create($validated);
        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['branch','shipments.sender']);
        return view('admin.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $branches = Branch::where('is_active', true)->get();
        return view('admin.vehicles.edit', compact('vehicle','branches'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'branch_id'    => 'nullable|exists:branches,id',
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number,'.$vehicle->id,
            'brand'        => 'nullable|string|max:100',
            'type'         => 'required|in:truck,van,motorcycle',
            'capacity_kg'  => 'required|numeric|min:0',
            'driver_name'  => 'nullable|string|max:255',
            'status'       => 'required|in:available,in_use,maintenance',
        ]);
        $vehicle->update($validated);
        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil dihapus.');
    }
}
