@extends('layouts.app')
@section('title','Tambah Pelanggan')
@section('page-title','Tambah Pelanggan')
@section('content')
<div class="form-card" style="max-width:600px">
    <div class="form-card-header"><h3><i class="fa fa-user-plus" style="color:var(--primary)"></i> Form Pelanggan Baru</h3></div>
    <form action="{{ route('admin.customers.store') }}" method="POST">
        @csrf
        <div class="form-card-body">
            <div class="form-group"><label class="form-label">Nama Lengkap *</label>
                <input type="text" name="name" class="form-control {{ $errors->has('name')?'is-invalid':'' }}" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control {{ $errors->has('email')?'is-invalid':'' }}" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="form-group"><label class="form-label">Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}"></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Kota</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city') }}"></div>
                <div class="form-group"><label class="form-label">Password *</label>
                    <input type="password" name="password" class="form-control {{ $errors->has('password')?'is-invalid':'' }}" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            </div>
            <div class="form-group"><label class="form-label">Konfirmasi Password *</label>
                <input type="password" name="password_confirmation" class="form-control" required></div>
            <div class="form-group"><label class="form-label">Alamat</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea></div>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
