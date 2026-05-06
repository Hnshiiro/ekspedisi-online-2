<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Daftar Pelanggan | EkspedisiKu</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--primary:#EE4D2D;--primary-dark:#C73E22}
body{font-family:'Inter',sans-serif;background:linear-gradient(135deg,#1a1a2e,#16213e,#0f3460);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:1.5rem}
.auth-card{background:#fff;border-radius:20px;padding:2.5rem;width:100%;max-width:460px;box-shadow:0 20px 60px rgba(0,0,0,.3)}
.auth-logo{text-align:center;margin-bottom:1.5rem}
.auth-logo-icon{width:48px;height:48px;background:var(--primary);border-radius:12px;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:1.3rem;margin-bottom:.6rem}
.auth-logo h1{font-size:1.4rem;font-weight:800}
.auth-logo h1 span{color:var(--primary)}
.form-group{margin-bottom:1rem}
.form-label{display:block;font-size:.78rem;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.03em;margin-bottom:.35rem}
.form-control{width:100%;padding:.65rem .9rem;border:1.5px solid #e5e7eb;border-radius:10px;font-family:inherit;font-size:.875rem;transition:all .2s}
.form-control:focus{outline:none;border-color:var(--primary);box-shadow:0 0 0 3px rgba(238,77,45,.1)}
.form-control.is-invalid{border-color:#dc2626}
.invalid-feedback{color:#dc2626;font-size:.78rem;margin-top:.3rem}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:.75rem}
@media(max-width:480px){.form-row{grid-template-columns:1fr}}
.btn-register{width:100%;padding:.8rem;background:var(--primary);color:#fff;border:none;border-radius:10px;font-size:.95rem;font-weight:700;cursor:pointer;transition:all .2s;font-family:inherit;margin-top:.5rem}
.btn-register:hover{background:var(--primary-dark)}
.auth-footer{text-align:center;margin-top:1.2rem;font-size:.875rem;color:#6b7280}
.auth-footer a{color:var(--primary);font-weight:600;text-decoration:none}
</style>
</head>
<body>
<div class="auth-card">
    <div class="auth-logo">
        <div class="auth-logo-icon"><i class="fa fa-user-plus"></i></div>
        <h1>Ekspedisi<span>Ku</span></h1>
        <p style="font-size:.875rem;color:#6b7280;margin-top:.2rem">Daftar Akun Pelanggan Baru</p>
    </div>

    <form action="{{ route('customer.register.store') }}" method="POST">
        @csrf
        <div class="form-row">
            <div class="form-group" style="grid-column:1/-1">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                    placeholder="Nama lengkap Anda" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    placeholder="email@gmail.com" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">No. HP</label>
                <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                    placeholder="08xxxxxxxxxx" value="{{ old('phone') }}" required>
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Kota</label>
            <input type="text" name="city" class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}"
                placeholder="cth. Jakarta" value="{{ old('city') }}" required>
            @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Alamat Lengkap</label>
            <textarea name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                placeholder="Jl. contoh No. 1, Kelurahan, Kecamatan..." rows="2" required>{{ old('address') }}</textarea>
            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="Min. 6 karakter" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>
        </div>
        <button type="submit" class="btn-register"><i class="fa fa-user-plus"></i> Daftar Sekarang</button>
    </form>
    <div class="auth-footer" style="margin-top:1.2rem">
        Sudah punya akun? <a href="{{ route('customer.login') }}">Login di sini</a>
        <br><br>
        <a href="{{ route('home') }}" style="color:#6b7280"><i class="fa fa-arrow-left"></i> Kembali ke Beranda</a>
    </div>
</div>
</body>
</html>
