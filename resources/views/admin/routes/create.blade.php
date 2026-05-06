@extends('layouts.app')
@section('title','Tambah Rute')
@section('page-title','Tambah Rute')
@section('content')
<div class="form-card" style="max-width:520px">
    <div class="form-card-header"><h3><i class="fa fa-route" style="color:var(--primary)"></i> Form Rute Baru</h3></div>
    <form action="{{ route('admin.routes.store') }}" method="POST">
        @csrf
        <div class="form-card-body">
            <div class="form-row">
                <div class="form-group"><label class="form-label">Kota Asal *</label>
                    <input type="text" name="origin_city" class="form-control {{ $errors->has('origin_city')?'is-invalid':'' }}" value="{{ old('origin_city') }}" required placeholder="cth. Jakarta">
                    @error('origin_city')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="form-group"><label class="form-label">Kota Tujuan *</label>
                    <input type="text" name="destination_city" class="form-control {{ $errors->has('destination_city')?'is-invalid':'' }}" value="{{ old('destination_city') }}" required placeholder="cth. Surabaya">
                    @error('destination_city')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Harga per kg (Rp) *</label>
                    <input type="number" name="price_per_kg" class="form-control {{ $errors->has('price_per_kg')?'is-invalid':'' }}" value="{{ old('price_per_kg') }}" min="0" required>
                    @error('price_per_kg')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="form-group"><label class="form-label">Estimasi Hari *</label>
                    <input type="number" name="estimated_days" class="form-control {{ $errors->has('estimated_days')?'is-invalid':'' }}" value="{{ old('estimated_days',1) }}" min="1" max="30" required>
                    @error('estimated_days')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            </div>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            <a href="{{ route('admin.routes.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
