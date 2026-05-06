@extends('layouts.app')
@section('title','Tambah Pengguna')
@section('page-title','Tambah Pengguna')
@section('content')
<div class="form-card" style="max-width:600px">
    <div class="form-card-header"><h3><i class="fa fa-user-plus" style="color:var(--primary)"></i> Form Pengguna Baru</h3></div>
    <form action="{{ route('admin.users.store') }}" method="POST">
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
                <div class="form-group"><label class="form-label">Role *</label>
                    <select name="role" class="form-control" required>
                        @foreach(['admin','branch_admin','courier','manager'] as $r)
                        <option value="{{ $r }}" {{ old('role')===$r?'selected':'' }}>{{ ucwords(str_replace('_',' ',$r)) }}</option>
                        @endforeach
                    </select></div>
                <div class="form-group"><label class="form-label">Cabang</label>
                    <select name="branch_id" class="form-control">
                        <option value="">-- Pilih Cabang --</option>
                        @foreach($branches as $b)<option value="{{ $b->id }}" {{ old('branch_id')==$b->id?'selected':'' }}>{{ $b->name }}</option>@endforeach
                    </select></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Password *</label>
                    <input type="password" name="password" class="form-control {{ $errors->has('password')?'is-invalid':'' }}" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="form-group"><label class="form-label">Konfirmasi Password *</label>
                    <input type="password" name="password_confirmation" class="form-control" required></div>
            </div>
            <div class="form-group">
                <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active',1)?'checked':'' }}>
                    <span class="form-label" style="margin:0">Pengguna Aktif</span>
                </label>
            </div>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
