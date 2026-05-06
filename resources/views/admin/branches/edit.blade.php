@extends('layouts.app')
@section('title','Edit Cabang')
@section('page-title','Edit Cabang')
@section('content')
<div class="form-card" style="max-width:640px">
    <div class="form-card-header"><h3><i class="fa fa-pen" style="color:var(--primary)"></i> Edit Cabang: {{ $branch->name }}</h3></div>
    <form action="{{ route('admin.branches.update',$branch) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-card-body">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Kode *</label>
                    <input type="text" name="code" class="form-control {{ $errors->has('code')?'is-invalid':'' }}" value="{{ old('code',$branch->code) }}" required>
                    @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Nama *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name',$branch->name) }}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Kota *</label><input type="text" name="city" class="form-control" value="{{ old('city',$branch->city) }}" required></div>
                <div class="form-group"><label class="form-label">Telepon</label><input type="text" name="phone" class="form-control" value="{{ old('phone',$branch->phone) }}"></div>
            </div>
            <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email',$branch->email) }}"></div>
            <div class="form-group"><label class="form-label">Alamat</label><textarea name="address" class="form-control" rows="2">{{ old('address',$branch->address) }}</textarea></div>
            <div class="form-group">
                <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active',$branch->is_active)?'checked':'' }}>
                    <span class="form-label" style="margin:0">Cabang Aktif</span>
                </label>
            </div>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
            <a href="{{ route('admin.branches.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
