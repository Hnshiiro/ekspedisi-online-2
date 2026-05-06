@extends('layouts.app')
@section('title','Edit Pengguna')
@section('page-title','Edit Pengguna')
@section('content')
<div class="form-card" style="max-width:600px">
    <div class="form-card-header"><h3><i class="fa fa-pen" style="color:var(--primary)"></i> Edit: {{ $user->name }}</h3></div>
    <form action="{{ route('admin.users.update',$user) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-card-body">
            <div class="form-group"><label class="form-label">Nama *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name',$user->name) }}" required></div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control {{ $errors->has('email')?'is-invalid':'' }}" value="{{ old('email',$user->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="form-group"><label class="form-label">Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone',$user->phone) }}"></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Role *</label>
                    <select name="role" class="form-control" required>
                        @foreach(['admin','branch_admin','courier','manager'] as $r)
                        <option value="{{ $r }}" {{ old('role',$user->role)===$r?'selected':'' }}>{{ ucwords(str_replace('_',' ',$r)) }}</option>
                        @endforeach
                    </select></div>
                <div class="form-group"><label class="form-label">Cabang</label>
                    <select name="branch_id" class="form-control">
                        <option value="">-- Tidak ada --</option>
                        @foreach($branches as $b)<option value="{{ $b->id }}" {{ old('branch_id',$user->branch_id)==$b->id?'selected':'' }}>{{ $b->name }}</option>@endforeach
                    </select></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Password Baru (opsional)</label>
                    <input type="password" name="password" class="form-control"></div>
                <div class="form-group"><label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control"></div>
            </div>
            <div class="form-group">
                <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active',$user->is_active)?'checked':'' }}>
                    <span class="form-label" style="margin:0">Pengguna Aktif</span>
                </label>
            </div>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
