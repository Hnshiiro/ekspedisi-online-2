@extends('layouts.app')

@section('title', isset($vehicle) ? 'Edit Kendaraan' : 'Tambah Kendaraan')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h2>{{ isset($vehicle) ? 'Edit Kendaraan' : 'Tambah Kendaraan Baru' }}</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ isset($vehicle) ? route('vehicles.update', $vehicle) : route('vehicles.store') }}" method="POST">
                    @csrf
                    @if (isset($vehicle))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="plate_number" class="form-label">Nomor Plat <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('plate_number') is-invalid @enderror" id="plate_number" name="plate_number" value="{{ old('plate_number', $vehicle->plate_number ?? '') }}" required>
                        @error('plate_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="branch_id" class="form-label">Cabang <span class="text-danger">*</span></label>
                        <select class="form-control @error('branch_id') is-invalid @enderror" id="branch_id" name="branch_id" required>
                            <option value="">-- Pilih Cabang --</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id', $vehicle->branch_id ?? '') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                        @error('branch_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="vehicle_type" class="form-label">Tipe Kendaraan</label>
                        <input type="text" class="form-control @error('vehicle_type') is-invalid @enderror" id="vehicle_type" name="vehicle_type" value="{{ old('vehicle_type', $vehicle->vehicle_type ?? '') }}" placeholder="e.g., Box Truck, Pick-up">
                        @error('vehicle_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="capacity_kg" class="form-label">Kapasitas (kg)</label>
                        <input type="number" class="form-control @error('capacity_kg') is-invalid @enderror" id="capacity_kg" name="capacity_kg" value="{{ old('capacity_kg', $vehicle->capacity_kg ?? '') }}" step="0.01">
                        @error('capacity_kg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="driver_name" class="form-label">Nama Pengemudi</label>
                        <input type="text" class="form-control @error('driver_name') is-invalid @enderror" id="driver_name" name="driver_name" value="{{ old('driver_name', $vehicle->driver_name ?? '') }}">
                        @error('driver_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="driver_phone" class="form-label">Telepon Pengemudi</label>
                        <input type="text" class="form-control @error('driver_phone') is-invalid @enderror" id="driver_phone" name="driver_phone" value="{{ old('driver_phone', $vehicle->driver_phone ?? '') }}">
                        @error('driver_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-check-label">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $vehicle->is_active ?? true) ? 'checked' : '' }}>
                            Aktif
                        </label>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">{{ isset($vehicle) ? 'Update' : 'Simpan' }}</button>
                        <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
