@extends('layouts.app')
@section('title','Tambah Kurir')
@section('page-title','Tambah Kurir Baru')
@section('breadcrumb','Tambah Kurir')
@section('content')
<div class="table-card" style="max-width:800px;margin:0 auto">
    <div class="table-card-header"><h3><i class="fa fa-user-plus"></i> Form Kurir</h3></div>
    <form action="{{ route('admin.couriers.store') }}" method="POST" style="padding:1.5rem">
        @csrf
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem">
            <div class="form-group">
                <label class="form-label">Nama Lengkap *</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Nomor Telepon</label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Cabang Tugas *</label>
                <select name="branch_id" class="form-control @error('branch_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Cabang --</option>
                    @foreach($branches as $b)
                    <option value="{{ $b->id }}" {{ old('branch_id')==$b->id?'selected':'' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
                @error('branch_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Password *</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Konfirmasi Password *</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
        </div>
        <div class="form-group" style="margin-top:1rem">
            <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer">
                <input type="checkbox" name="is_active" value="1" checked> <span>Akun Aktif</span>
            </label>
        </div>
        <div style="margin-top:2rem;display:flex;gap:1rem">
            <button type="submit" class="btn btn-primary">Simpan Kurir</button>
            <a href="{{ route('admin.couriers.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
