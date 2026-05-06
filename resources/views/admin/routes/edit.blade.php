@extends('layouts.app')
@section('title','Edit Rute')
@section('page-title','Edit Rute')
@section('content')
<div class="form-card" style="max-width:520px">
    <div class="form-card-header"><h3><i class="fa fa-pen" style="color:var(--primary)"></i> Edit Rute: {{ $route->origin_city }} → {{ $route->destination_city }}</h3></div>
    <form action="{{ route('admin.routes.update',$route) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-card-body">
            <div class="form-row">
                <div class="form-group"><label class="form-label">Kota Asal *</label>
                    <input type="text" name="origin_city" class="form-control" value="{{ old('origin_city',$route->origin_city) }}" required></div>
                <div class="form-group"><label class="form-label">Kota Tujuan *</label>
                    <input type="text" name="destination_city" class="form-control" value="{{ old('destination_city',$route->destination_city) }}" required></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Harga/kg (Rp) *</label>
                    <input type="number" name="price_per_kg" class="form-control" value="{{ old('price_per_kg',$route->price_per_kg) }}" min="0" required></div>
                <div class="form-group"><label class="form-label">Estimasi Hari *</label>
                    <input type="number" name="estimated_days" class="form-control" value="{{ old('estimated_days',$route->estimated_days) }}" min="1" max="30" required></div>
            </div>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
            <a href="{{ route('admin.routes.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
