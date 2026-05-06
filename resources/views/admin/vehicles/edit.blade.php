@extends('layouts.app')
@section('title','Edit Kendaraan')
@section('page-title','Edit Kendaraan')
@section('content')
<div class="form-card" style="max-width:600px">
    <div class="form-card-header"><h3><i class="fa fa-pen" style="color:var(--primary)"></i> Edit: {{ $vehicle->plate_number }}</h3></div>
    <form action="{{ route('admin.vehicles.update',$vehicle) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-card-body">
            <div class="form-row">
                <div class="form-group"><label class="form-label">Plat Nomor *</label>
                    <input type="text" name="plate_number" class="form-control {{ $errors->has('plate_number')?'is-invalid':'' }}" value="{{ old('plate_number',$vehicle->plate_number) }}" required>
                    @error('plate_number')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="form-group"><label class="form-label">Merek</label>
                    <input type="text" name="brand" class="form-control" value="{{ old('brand',$vehicle->brand) }}"></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Tipe *</label>
                    <select name="type" class="form-control" required>
                        @foreach(['truck','van','motorcycle'] as $t)
                        <option value="{{ $t }}" {{ old('type',$vehicle->type)===$t?'selected':'' }}>{{ ucfirst($t) }}</option>
                        @endforeach
                    </select></div>
                <div class="form-group"><label class="form-label">Kapasitas (kg) *</label>
                    <input type="number" name="capacity_kg" class="form-control" value="{{ old('capacity_kg',$vehicle->capacity_kg) }}" min="0" required></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Driver</label>
                    <input type="text" name="driver_name" class="form-control" value="{{ old('driver_name',$vehicle->driver_name) }}"></div>
                <div class="form-group"><label class="form-label">Status *</label>
                    <select name="status" class="form-control" required>
                        @foreach(['available','in_use','maintenance'] as $s)
                        <option value="{{ $s }}" {{ old('status',$vehicle->status)===$s?'selected':'' }}>{{ ucwords(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select></div>
            </div>
            <div class="form-group"><label class="form-label">Cabang</label>
                <select name="branch_id" class="form-control">
                    <option value="">-- Pilih Cabang --</option>
                    @foreach($branches as $b)<option value="{{ $b->id }}" {{ old('branch_id',$vehicle->branch_id)==$b->id?'selected':'' }}>{{ $b->name }}</option>@endforeach
                </select></div>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
            <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
