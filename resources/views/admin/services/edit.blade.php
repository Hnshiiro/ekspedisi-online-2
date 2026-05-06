@extends('layouts.app')
@section('title','Edit Layanan')
@section('page-title','Edit Layanan')
@section('content')
<div class="form-card" style="max-width:540px">
    <div class="form-card-header"><h3><i class="fa fa-pen" style="color:var(--primary)"></i> Edit: {{ $service->name }}</h3></div>
    <form action="{{ route('admin.services.update',$service) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-card-body">
            <div class="form-group"><label class="form-label">Nama *</label>
                <input type="text" name="name" class="form-control {{ $errors->has('name')?'is-invalid':'' }}" value="{{ old('name',$service->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="form-group"><label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="2">{{ old('description',$service->description) }}</textarea></div>
            <div class="form-group"><label class="form-label">Multiplier Harga *</label>
                <input type="number" name="price_multiplier" class="form-control" step="0.01" min="0.1" value="{{ old('price_multiplier',$service->price_multiplier) }}" required></div>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
