@extends('layouts.app')

@section('title', 'Edit Pengiriman - ' . $shipment->shipment_number)

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2>Edit Pengiriman</h2>
        <p class="text-muted">{{ $shipment->shipment_number }}</p>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('shipments.update', $shipment) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h5 class="mb-3">Data Penerima</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="receiver_name" class="form-label">Nama Penerima <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('receiver_name') is-invalid @enderror" id="receiver_name" name="receiver_name" value="{{ old('receiver_name', $shipment->receiver_name) }}" required>
                            @error('receiver_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="receiver_phone" class="form-label">Telepon Penerima <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('receiver_phone') is-invalid @enderror" id="receiver_phone" name="receiver_phone" value="{{ old('receiver_phone', $shipment->receiver_phone) }}" required>
                            @error('receiver_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="receiver_address" class="form-label">Alamat Penerima <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('receiver_address') is-invalid @enderror" id="receiver_address" name="receiver_address" rows="2" required>{{ old('receiver_address', $shipment->receiver_address) }}</textarea>
                        @error('receiver_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="destination_city" class="form-label">Kota Tujuan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('destination_city') is-invalid @enderror" id="destination_city" name="destination_city" value="{{ old('destination_city', $shipment->destination_city) }}" required>
                        @error('destination_city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <h5 class="mb-3">Jadwal & Catatan</h5>
                    <div class="mb-3">
                        <label for="estimated_delivery_date" class="form-label">Est. Pengiriman <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('estimated_delivery_date') is-invalid @enderror" id="estimated_delivery_date" name="estimated_delivery_date" value="{{ old('estimated_delivery_date', $shipment->estimated_delivery_date->format('Y-m-d')) }}" required>
                        @error('estimated_delivery_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="vehicle_id" class="form-label">Kendaraan</label>
                        <select class="form-control @error('vehicle_id') is-invalid @enderror" id="vehicle_id" name="vehicle_id">
                            <option value="">-- Pilih Kendaraan --</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $shipment->vehicle_id) == $vehicle->id ? 'selected' : '' }}>{{ $vehicle->plate_number }} ({{ $vehicle->driver_name ?? '-' }})</option>
                            @endforeach
                        </select>
                        @error('vehicle_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan Tambahan</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes', $shipment->notes) }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">Update Pengiriman</button>
                        <a href="{{ route('shipments.show', $shipment) }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
