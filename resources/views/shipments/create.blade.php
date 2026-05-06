@extends('layouts.app')

@section('title', 'Buat Pengiriman Baru')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2>Buat Pengiriman Baru</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('shipments.store') }}" method="POST">
                    @csrf

                    <!-- Bagian 1: Data Pelanggan & Cabang -->
                    <h5 class="mb-3">Informasi Pengiriman</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="customer_id" class="form-label">Pelanggan <span class="text-danger">*</span></label>
                            <select class="form-control @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="branch_id" class="form-label">Cabang Asal <span class="text-danger">*</span></label>
                            <select class="form-control @error('branch_id') is-invalid @enderror" id="branch_id" name="branch_id" required>
                                <option value="">-- Pilih Cabang --</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            @error('branch_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="shipment_date" class="form-label">Tanggal Pengiriman <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('shipment_date') is-invalid @enderror" id="shipment_date" name="shipment_date" value="{{ old('shipment_date') }}" required>
                            @error('shipment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="estimated_delivery_date" class="form-label">Est. Pengiriman <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('estimated_delivery_date') is-invalid @enderror" id="estimated_delivery_date" name="estimated_delivery_date" value="{{ old('estimated_delivery_date') }}" required>
                            @error('estimated_delivery_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    <!-- Bagian 2: Data Pengirim -->
                    <h5 class="mb-3">Data Pengirim</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sender_name" class="form-label">Nama Pengirim <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('sender_name') is-invalid @enderror" id="sender_name" name="sender_name" value="{{ old('sender_name') }}" required>
                            @error('sender_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sender_phone" class="form-label">Telepon Pengirim <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('sender_phone') is-invalid @enderror" id="sender_phone" name="sender_phone" value="{{ old('sender_phone') }}" required>
                            @error('sender_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="sender_address" class="form-label">Alamat Pengirim <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('sender_address') is-invalid @enderror" id="sender_address" name="sender_address" rows="2" required>{{ old('sender_address') }}</textarea>
                        @error('sender_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="origin_city" class="form-label">Kota Asal <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('origin_city') is-invalid @enderror" id="origin_city" name="origin_city" value="{{ old('origin_city') }}" required>
                        @error('origin_city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <!-- Bagian 3: Data Penerima -->
                    <h5 class="mb-3">Data Penerima</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="receiver_name" class="form-label">Nama Penerima <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('receiver_name') is-invalid @enderror" id="receiver_name" name="receiver_name" value="{{ old('receiver_name') }}" required>
                            @error('receiver_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="receiver_phone" class="form-label">Telepon Penerima <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('receiver_phone') is-invalid @enderror" id="receiver_phone" name="receiver_phone" value="{{ old('receiver_phone') }}" required>
                            @error('receiver_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="receiver_address" class="form-label">Alamat Penerima <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('receiver_address') is-invalid @enderror" id="receiver_address" name="receiver_address" rows="2" required>{{ old('receiver_address') }}</textarea>
                        @error('receiver_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="destination_city" class="form-label">Kota Tujuan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('destination_city') is-invalid @enderror" id="destination_city" name="destination_city" value="{{ old('destination_city') }}" required>
                        @error('destination_city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <!-- Bagian 4: Detail Paket -->
                    <h5 class="mb-3">Detail Paket</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="package_count" class="form-label">Jumlah Paket <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('package_count') is-invalid @enderror" id="package_count" name="package_count" value="{{ old('package_count') }}" min="1" required>
                            @error('package_count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="total_weight" class="form-label">Berat Total (kg) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('total_weight') is-invalid @enderror" id="total_weight" name="total_weight" value="{{ old('total_weight') }}" step="0.01" min="0" required>
                            @error('total_weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    <!-- Bagian 5: Biaya -->
                    <h5 class="mb-3">Rincian Biaya</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="subtotal" class="form-label">Subtotal (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('subtotal') is-invalid @enderror" id="subtotal" name="subtotal" value="{{ old('subtotal') }}" step="0.01" min="0" required>
                            @error('subtotal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="shipping_cost" class="form-label">Biaya Pengiriman (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('shipping_cost') is-invalid @enderror" id="shipping_cost" name="shipping_cost" value="{{ old('shipping_cost') }}" step="0.01" min="0" required>
                            @error('shipping_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan Tambahan</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Instruksi khusus atau catatan lainnya">{{ old('notes') }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">Buat Pengiriman</button>
                        <a href="{{ route('shipments.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
