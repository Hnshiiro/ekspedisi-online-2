@extends('customer.dashboard')
@section('customer-content')
<div style="background:#fff;border-radius:16px;border:1px solid var(--gray-200);box-shadow:var(--shadow);overflow:hidden;padding:1.5rem">
    <h2 style="font-size:1.2rem;font-weight:800;margin-bottom:1.5rem"><i class="fa fa-user-gear" style="color:var(--primary)"></i> Pengaturan Profil</h2>
    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="form-group" style="margin-bottom:1.5rem">
            <label class="form-label">Foto Profil Baru (Opsional)</label>
            <input type="file" name="photo" class="form-control" accept="image/*">
            <small style="color:var(--gray-400)">Format: JPG, PNG, JPEG (Maks. 2MB)</small>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.2rem">
            <div class="form-group"><label class="form-label">Nama Lengkap</label><input type="text" name="name" class="form-control" value="{{ old('name',$customer->name) }}" required></div>
            <div class="form-group"><label class="form-label">Email (Tidak bisa diubah)</label><input type="email" class="form-control" value="{{ $customer->email }}" disabled style="background:var(--gray-100)"></div>
            <div class="form-group"><label class="form-label">No. Telepon</label><input type="text" name="phone" class="form-control" value="{{ old('phone',$customer->phone) }}"></div>
            <div class="form-group"><label class="form-label">Kota</label><input type="text" name="city" class="form-control" value="{{ old('city',$customer->city) }}"></div>
        </div>
        <div class="form-group" style="margin-top:1.2rem"><label class="form-label">Alamat Lengkap</label><textarea name="address" rows="3" class="form-control">{{ old('address',$customer->address) }}</textarea></div>
        <hr style="border:none;border-top:1px solid var(--gray-200);margin:2rem 0">
        <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem">Ubah Password (opsional)</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.2rem">
            <div class="form-group"><label class="form-label">Password Baru</label><input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah"></div>
            <div class="form-group"><label class="form-label">Konfirmasi Password</label><input type="password" name="password_confirmation" class="form-control"></div>
        </div>
        <div style="margin-top:1.5rem"><button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button></div>
    </form>
</div>
@endsection
