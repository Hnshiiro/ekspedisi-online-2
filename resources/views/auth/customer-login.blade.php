<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Login Pelanggan | EkspedisiKu</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--primary:#EE4D2D;--primary-dark:#C73E22}
body{font-family:'Inter',sans-serif;background:linear-gradient(135deg,#1a1a2e,#16213e,#0f3460);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:1.5rem}
.auth-card{background:#fff;border-radius:20px;padding:2.5rem;width:100%;max-width:420px;box-shadow:0 20px 60px rgba(0,0,0,.3)}
.auth-logo{text-align:center;margin-bottom:1.8rem}
.auth-logo-icon{width:56px;height:56px;background:var(--primary);border-radius:14px;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:1.5rem;margin-bottom:.75rem}
.auth-logo h1{font-size:1.5rem;font-weight:800}
.auth-logo h1 span{color:var(--primary)}
.auth-logo p{font-size:.875rem;color:#6b7280;margin-top:.25rem}
.form-group{margin-bottom:1.1rem}
.form-label{display:block;font-size:.8rem;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.03em;margin-bottom:.4rem}
.form-control{width:100%;padding:.7rem 1rem;border:1.5px solid #e5e7eb;border-radius:10px;font-family:inherit;font-size:.9rem;transition:all .2s}
.form-control:focus{outline:none;border-color:var(--primary);box-shadow:0 0 0 3px rgba(238,77,45,.12)}
.form-control.is-invalid{border-color:#dc2626}
.invalid-feedback{color:#dc2626;font-size:.8rem;margin-top:.3rem}
.btn-login{width:100%;padding:.85rem;background:var(--primary);color:#fff;border:none;border-radius:10px;font-size:1rem;font-weight:700;cursor:pointer;transition:all .2s;font-family:inherit}
.btn-login:hover{background:var(--primary-dark);transform:translateY(-1px);box-shadow:0 4px 12px rgba(238,77,45,.35)}
.auth-footer{text-align:center;margin-top:1.2rem;font-size:.875rem;color:#6b7280}
.auth-footer a{color:var(--primary);font-weight:600;text-decoration:none}
</style>
</head>
<body>
<div class="auth-card">
    <div class="auth-logo">
        <div class="auth-logo-icon"><i class="fa fa-user"></i></div>
        <h1>Ekspedisi<span>Ku</span></h1>
        <p>Login Pelanggan</p>
    </div>

    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:.75rem 1rem;font-size:.85rem;color:#166534;margin-bottom:1rem"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:.75rem 1rem;font-size:.85rem;color:#991b1b;margin-bottom:1rem"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    <form action="{{ route('customer.login.attempt') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                placeholder="email@gmail.com" value="{{ old('email') }}" required autofocus>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <div style="font-size:.85rem;margin-bottom:1.2rem">
            <label style="display:flex;align-items:center;gap:.4rem;cursor:pointer;color:#4b5563">
                <input type="checkbox" name="remember"> Ingat saya
            </label>
        </div>
        <button type="submit" class="btn-login"><i class="fa fa-right-to-bracket"></i> Masuk</button>
    </form>
    <div class="auth-footer" style="margin-top:1.2rem">
        Belum punya akun? <a href="{{ route('customer.register') }}">Daftar Sekarang</a>
        <br><br>
        <a href="{{ route('home') }}" style="color:#6b7280"><i class="fa fa-arrow-left"></i> Kembali ke Beranda</a>
        <br><a href="{{ route('login') }}" style="color:#6b7280;margin-top:.5rem;display:inline-block">Login Staff / Admin</a>
    </div>
</div>
</body>
</html>
