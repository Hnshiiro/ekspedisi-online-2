<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Ekspedisi Online</title>
    <meta name="description" content="Buat akun client atau admin untuk masuk ke sistem pengiriman.">
    <style>
        :root {
            --bg: #eef4ff;
            --surface: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --line: #dbe4f0;
            --primary: #1d4ed8;
            --shadow: 0 20px 50px rgba(15, 23, 42, 0.12);
            --radius: 24px;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.14), transparent 32%),
                linear-gradient(135deg, #dce9ff 0%, #f7fbff 46%, #e8eef7 100%);
        }

        a { color: inherit; }

        .shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 0.98fr 1.02fr;
        }

        .brand-panel {
            padding: 36px;
            color: #fff;
            background: linear-gradient(145deg, rgba(18, 63, 149, 0.96), rgba(29, 78, 216, 0.96));
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .brand-panel::before,
        .brand-panel::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.10);
        }

        .brand-panel::before {
            width: 300px;
            height: 300px;
            right: -120px;
            top: -90px;
        }

        .brand-panel::after {
            width: 210px;
            height: 210px;
            left: -90px;
            bottom: -70px;
        }

        .brand-top,
        .brand-bottom {
            position: relative;
            z-index: 1;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            font-size: 1.05rem;
            text-decoration: none;
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .brand-copy {
            margin-top: 42px;
            max-width: 520px;
        }

        .brand-copy h1 {
            margin: 0;
            font-size: clamp(2rem, 4vw, 3.6rem);
            line-height: 1.02;
            letter-spacing: -0.03em;
        }

        .brand-copy p {
            margin: 18px 0 0;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.7;
            max-width: 48ch;
        }

        .register-points {
            display: grid;
            gap: 12px;
            margin-top: 28px;
        }

        .point {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            padding: 14px 16px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.10);
        }

        .point span {
            font-size: 18px;
            line-height: 1;
        }

        .point strong,
        .point p {
            display: block;
        }

        .point strong {
            margin-bottom: 4px;
            font-size: 14px;
        }

        .point p {
            margin: 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 13px;
            line-height: 1.5;
        }

        .brand-bottom {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 28px;
            color: rgba(255, 255, 255, 0.78);
            font-size: 13px;
        }

        .form-panel {
            padding: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            width: min(560px, 100%);
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(219, 228, 240, 0.85);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 32px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: #eef4ff;
            color: var(--primary);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        h2 {
            margin: 16px 0 8px;
            font-size: 1.9rem;
            letter-spacing: -0.03em;
        }

        .subtitle {
            margin: 0 0 22px;
            color: var(--muted);
            line-height: 1.7;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 14px;
            margin-bottom: 16px;
            font-size: 14px;
            line-height: 1.6;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .row-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 13px;
            font-weight: 700;
            color: #334155;
        }

        .input,
        .select {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 16px;
            padding: 14px 16px;
            font-size: 14px;
            outline: none;
            background: #fff;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .input:focus,
        .select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(29, 78, 216, 0.12);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            border: 0;
            border-radius: 16px;
            padding: 14px 16px;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            color: #fff;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            box-shadow: 0 14px 28px rgba(37, 99, 235, 0.24);
        }

        .links {
            margin-top: 18px;
            display: flex;
            justify-content: center;
            gap: 18px;
            flex-wrap: wrap;
            font-size: 14px;
        }

        .links a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
        }

        .links a:hover {
            text-decoration: underline;
        }

        @media (max-width: 980px) {
            .shell {
                grid-template-columns: 1fr;
            }

            .brand-panel {
                min-height: 420px;
            }
        }

        @media (max-width: 720px) {
            .form-panel,
            .brand-panel {
                padding: 20px;
            }

            .card {
                padding: 24px;
            }

            .row-grid {
                grid-template-columns: 1fr;
            }

            .brand-copy h1 {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body>
    <main class="shell">
        <section class="brand-panel">
            <div class="brand-top">
                <a href="{{ route('home') }}" class="brand">
                    <span class="brand-mark">E</span>
                    <span>Ekspedisi Online</span>
                </a>

                <div class="brand-copy">
                    <h1>Buat akun untuk akses yang sesuai role dan alur yang rapi.</h1>
                    <p>
                        Client bisa memakai layanan tracking, sementara admin memiliki akses operasional ke dashboard.
                        Proses registrasi dibuat singkat dan jelas.
                    </p>

                    <div class="register-points">
                        <div class="point">
                            <span>✨</span>
                            <div>
                                <strong>Registrasi cepat</strong>
                                <p>Isi nama, email, password, dan role dalam satu form yang ringkas.</p>
                            </div>
                        </div>
                        <div class="point">
                            <span>🧭</span>
                            <div>
                                <strong>Akses terarah</strong>
                                <p>Client dan admin tetap punya jalur login yang berbeda sesuai kebutuhan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="brand-bottom">
                <span>Client & admin</span>
                <span>Registrasi aman</span>
                <span>Langsung siap login</span>
            </div>
        </section>

        <section class="form-panel">
            <div class="card">
                <div class="eyebrow">Register</div>
                <h2>Buat akun baru</h2>
                <p class="subtitle">Pilih role saat registrasi. Setelah berhasil daftar, kamu akan diarahkan ke halaman login.</p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin: 0; padding-left: 18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="input" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="input" required>
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role" class="select" required>
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih role...</option>
                            <option value="client" {{ old('role') === 'client' ? 'selected' : '' }}>Client / User Biasa</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div class="row-grid">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="input" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="input" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                </form>

                <div class="links">
                    <a href="{{ route('login') }}">Sudah punya akun? Login</a>
                    <a href="{{ route('home') }}">Kembali ke home</a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
