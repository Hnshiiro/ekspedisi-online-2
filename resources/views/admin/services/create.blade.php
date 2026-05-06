@extends('layouts.app')
@section('title','Tambah Layanan')
@section('page-title','Tambah Layanan')
@section('content')
<div class="form-card" style="max-width:540px">
    <div class="form-card-header"><h3><i class="fa fa-layer-group" style="color:var(--primary)"></i> Form Layanan Baru</h3></div>
    <form action="{{ route('admin.services.store') }}" method="POST">
        @csrf
        <div class="form-card-body">
            <div class="form-group"><label class="form-label">Nama Layanan *</label>
                <input type="text" name="name" class="form-control {{ $errors->has('name')?'is-invalid':'' }}" value="{{ old('name') }}" required placeholder="cth. Reguler">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="form-group"><label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="2" placeholder="Keterangan layanan...">{{ old('description') }}</textarea></div>
            <div class="form-group"><label class="form-label">Multiplier Harga * <span style="font-size:.78rem;color:var(--gray-400)">(1.0 = normal, 2.0 = 2x lipat)</span></label>
                <input type="number" name="price_multiplier" class="form-control {{ $errors->has('price_multiplier')?'is-invalid':'' }}" step="0.01" min="0.1" value="{{ old('price_multiplier', 1.00) }}" required>
                @error('price_multiplier')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
