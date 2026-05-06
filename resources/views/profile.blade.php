@extends('layouts.app')
@section('title','Profil Saya')
@section('page-title','Profil Pengguna')
@section('breadcrumb','Profil')
@section('content')
<div style="display:grid;grid-template-columns:1fr 2fr;gap:1.5rem;align-items:start">
    
    <!-- Info Card -->
    <div class="table-card" style="padding:1.5rem;text-align:center">
        <div style="position:relative;width:120px;height:120px;margin:0 auto 1.5rem">
            @if($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;border:4px solid #fff;box-shadow:var(--shadow)">
            @else
                <div style="width:100%;height:100%;background:var(--primary);color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:3rem;font-weight:800;border:4px solid #fff;box-shadow:var(--shadow)">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
        </div>
        <h3 style="font-size:1.2rem;margin-bottom:.2rem">{{ $user->name }}</h3>
        <p style="color:var(--gray-500);font-size:.875rem;margin-bottom:1.5rem">{{ ucwords(str_replace('_',' ',$user->role)) }}</p>
        
        <div style="text-align:left;background:var(--gray-50);border-radius:12px;padding:1rem;border:1px solid var(--gray-100)">
            <div style="margin-bottom:.8rem">
                <label style="display:block;font-size:.7rem;font-weight:700;color:var(--gray-400);text-transform:uppercase">Email</label>
                <div style="font-weight:600">{{ $user->email }}</div>
            </div>
            <div style="margin-bottom:.8rem">
                <label style="display:block;font-size:.7rem;font-weight:700;color:var(--gray-400);text-transform:uppercase">Telepon</label>
                <div style="font-weight:600">{{ $user->phone ?? '-' }}</div>
            </div>
            <div>
                <label style="display:block;font-size:.7rem;font-weight:700;color:var(--gray-400);text-transform:uppercase">Cabang Tugas</label>
                <div style="font-weight:600"><span class="badge badge-info">{{ $user->branch->name ?? 'Pusat' }}</span></div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="table-card" style="padding:1.5rem">
        <h3 style="font-size:1rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:.5rem"><i class="fa fa-user-gear" style="color:var(--primary)"></i> Edit Profil & Keamanan</h3>
        
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <div class="form-group" style="margin-bottom:1.5rem">
                <label class="form-label">Foto Profil Baru (Opsional)</label>
                <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                <small style="color:var(--gray-400)">Format: JPG, PNG, JPEG (Maks. 2MB)</small>
                @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.2rem">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap @if($user->role !== 'admin') <i class="fa fa-lock" style="font-size:.7rem;color:var(--gray-400)"></i> @endif</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required {{ $user->role !== 'admin' ? 'readonly' : '' }} style="{{ $user->role !== 'admin' ? 'background:var(--gray-50);cursor:not-allowed' : '' }}">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Email @if($user->role !== 'admin') <i class="fa fa-lock" style="font-size:.7rem;color:var(--gray-400)"></i> @endif</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required {{ $user->role !== 'admin' ? 'readonly' : '' }} style="{{ $user->role !== 'admin' ? 'background:var(--gray-50);cursor:not-allowed' : '' }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group" style="grid-column: 1 / -1">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div style="margin-top:1.5rem;padding-top:1.5rem;border-top:1px solid var(--gray-100)">
                <h4 style="font-size:.9rem;margin-bottom:1rem;color:var(--gray-600)">Ganti Kata Sandi (Kosongkan jika tidak ingin diubah)</h4>
                
                <div class="form-group">
                    <label class="form-label">Password Saat Ini</label>
                    <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                    @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.2rem">
                    <div class="form-group">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>
            </div>

            <div style="margin-top:2rem">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
