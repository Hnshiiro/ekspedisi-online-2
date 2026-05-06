@extends('layouts.app')
@section('title','Tambah Cabang')
@section('page-title','Tambah Cabang')
@section('content')
<div class="form-card" style="max-width:640px">
    <div class="form-card-header"><h3><i class="fa fa-building" style="color:var(--primary)"></i> Form Cabang Baru</h3></div>
    <form action="{{ route('admin.branches.store') }}" method="POST">
        @csrf
        <div class="form-card-body">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Kode Cabang *</label>
                    <input type="text" name="code" class="form-control {{ $errors->has('code')?'is-invalid':'' }}" value="{{ old('code') }}" placeholder="cth. JKT-02" required>
                    @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Cabang *</label>
                    <input type="text" name="name" class="form-control {{ $errors->has('name')?'is-invalid':'' }}" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Kota *</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Alamat</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
            </div>
            <div class="form-group">
                <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active',1)?'checked':'' }}>
                    <span class="form-label" style="margin:0">Cabang Aktif</span>
                </label>
            </div>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            <a href="{{ route('admin.branches.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
