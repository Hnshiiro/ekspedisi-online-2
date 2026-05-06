@extends('layouts.app')
@section('title','Edit Pelanggan')
@section('page-title','Edit Pelanggan')
@section('content')
<div class="form-card" style="max-width:600px">
    <div class="form-card-header"><h3><i class="fa fa-pen" style="color:var(--primary)"></i> Edit: {{ $customer->name }}</h3></div>
    <form action="{{ route('admin.customers.update',$customer) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-card-body">
            <div class="form-group"><label class="form-label">Nama *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name',$customer->name) }}" required></div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control {{ $errors->has('email')?'is-invalid':'' }}" value="{{ old('email',$customer->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="form-group"><label class="form-label">Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone',$customer->phone) }}"></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Kota</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city',$customer->city) }}"></div>
                <div class="form-group"><label class="form-label">Password Baru (opsional)</label>
                    <input type="password" name="password" class="form-control"></div>
            </div>
            <div class="form-group"><label class="form-label">Alamat</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address',$customer->address) }}</textarea></div>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
