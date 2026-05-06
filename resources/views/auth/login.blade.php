<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Login Staff | EkspedisiKu</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--primary:#EE4D2D;--primary-dark:#C73E22}
body{font-family:'Inter',sans-serif;background:linear-gradient(135deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:1.5rem}
.auth-card{background:#fff;border-radius:20px;padding:2.5rem;width:100%;max-width:420px;box-shadow:0 20px 60px rgba(0,0,0,.3)}
.auth-logo{text-align:center;margin-bottom:1.8rem}
.auth-logo-icon{width:56px;height:56px;background:var(--primary);border-radius:14px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.5rem;margin:0 auto .75rem}
.auth-logo h1{font-size:1.5rem;font-weight:800;color:#1f2937}
.auth-logo h1 span{color:var(--primary)}
.auth-logo p{font-size:.875rem;color:#6b7280;margin-top:.3rem}
.form-group{margin-bottom:1.1rem}
.form-label{display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.4rem;text-transform:uppercase;letter-spacing:.03em}
.form-control{width:100%;padding:.7rem 1rem;border:1.5px solid #e5e7eb;border-radius:10px;font-family:inherit;font-size:.9rem;color:#1f2937;transition:all .2s}
.form-control:focus{outline:none;border-color:var(--primary);box-shadow:0 0 0 3px rgba(238,77,45,.12)}
.form-control.is-invalid{border-color:#dc2626}
.invalid-feedback{color:#dc2626;font-size:.8rem;margin-top:.3rem}
.btn-login{width:100%;padding:.85rem;background:var(--primary);color:#fff;border:none;border-radius:10px;font-size:1rem;font-weight:700;cursor:pointer;transition:all .2s;font-family:inherit}
.btn-login:hover{background:var(--primary-dark);transform:translateY(-1px);box-shadow:0 4px 12px rgba(238,77,45,.35)}
.auth-footer{text-align:center;margin-top:1.5rem;font-size:.875rem;color:#6b7280}
.auth-footer a{color:var(--primary);font-weight:600;text-decoration:none}
.divider{border:none;border-top:1px solid #f3f4f6;margin:1.2rem 0}
.role-info{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:.75rem 1rem;font-size:.8rem;color:#166534;margin-bottom:1.2rem}
</style>
</head>
<body>
<div class="auth-card">
    <div class="auth-logo">
        <div class="auth-logo-icon"><i class="fa fa-truck-fast"></i></div>
        <h1>Ekspedisi<span>Ku</span></h1>
        <p>Login Staff & Admin</p>
    </div>

    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:.75rem 1rem;font-size:.85rem;color:#166534;margin-bottom:1rem;display:flex;gap:.5rem;align-items:center">
        <i class="fa fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:.75rem 1rem;font-size:.85rem;color:#991b1b;margin-bottom:1rem;display:flex;gap:.5rem;align-items:center">
        <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
    </div>
    @endif

    <div class="role-info">
        <i class="fa fa-circle-info"></i>
        Login khusus untuk <strong>Admin, Branch Admin, Kurir,</strong> dan <strong>Manager</strong>.
        Pelanggan? <a href="{{ route('customer.login') }}" style="color:#15803d;font-weight:700">Login di sini</a>
    </div>

    <form action="{{ route('login.attempt') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                placeholder="email@ekspedisiku.id" value="{{ old('email') }}" required autofocus>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                placeholder="••••••••" required>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.2rem;font-size:.85rem">
            <label style="display:flex;align-items:center;gap:.4rem;cursor:pointer;color:#4b5563">
                <input type="checkbox" name="remember"> Ingat saya
            </label>
        </div>
        <button type="submit" class="btn-login"><i class="fa fa-right-to-bracket"></i> Masuk</button>
    </form>
    <hr class="divider">
    <div class="auth-footer">
        Pelanggan? <a href="{{ route('customer.login') }}">Login sebagai Pelanggan</a>
        <br><br>
        <a href="{{ route('home') }}" style="color:#6b7280"><i class="fa fa-arrow-left"></i> Kembali ke Beranda</a>
    </div>
</div>
</body>
</html>
