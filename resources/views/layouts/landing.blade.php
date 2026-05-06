<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="EkspedisiKu - Layanan pengiriman ekspedisi cepat dan terpercaya ke seluruh Indonesia">
<title>@yield('title', 'EkspedisiKu') | Ekspedisi Cepat & Terpercaya</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --primary:#EE4D2D;--primary-dark:#C73E22;--primary-light:#FF6B4A;
  --orange-bg:#FFF3F0;--blue:#2673DD;--blue-dark:#1a5bbf;
  --gray-50:#f9fafb;--gray-100:#f3f4f6;--gray-200:#e5e7eb;
  --gray-400:#9ca3af;--gray-600:#4b5563;--gray-800:#1f2937;--gray-900:#111827;
  --success:#16a34a;--warning:#d97706;--danger:#dc2626;--info:#0891b2;
  --radius:12px;--radius-sm:8px;--shadow:0 4px 24px rgba(0,0,0,.08);--shadow-lg:0 8px 40px rgba(0,0,0,.14);
}
html{scroll-behavior:smooth}
body{font-family:'Inter',sans-serif;color:var(--gray-800);background:#fff;line-height:1.6}
a{text-decoration:none;color:inherit}
img{max-width:100%;height:auto}

/* NAVBAR */
.navbar{position:sticky;top:0;z-index:1000;background:#fff;border-bottom:1px solid var(--gray-200);padding:0 1.5rem;display:flex;align-items:center;justify-content:space-between;height:64px;box-shadow:0 2px 8px rgba(0,0,0,.06)}
.navbar-brand{display:flex;align-items:center;gap:.6rem;font-size:1.4rem;font-weight:800;color:var(--primary)}
.navbar-brand span{color:var(--gray-900)}
.navbar-brand .logo-icon{width:36px;height:36px;background:var(--primary);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.1rem}
.navbar-nav{display:flex;align-items:center;gap:.25rem}
.nav-link{padding:.45rem .9rem;border-radius:8px;font-size:.9rem;font-weight:500;color:var(--gray-600);transition:all .2s}
.nav-link:hover,.nav-link.active{color:var(--primary);background:var(--orange-bg)}
.btn{display:inline-flex;align-items:center;gap:.4rem;padding:.55rem 1.2rem;border-radius:8px;font-size:.9rem;font-weight:600;cursor:pointer;border:none;transition:all .2s;text-decoration:none}
.btn-primary{background:var(--primary);color:#fff}
.btn-primary:hover{background:var(--primary-dark);transform:translateY(-1px);box-shadow:0 4px 12px rgba(238,77,45,.35)}
.btn-outline{background:transparent;color:var(--primary);border:2px solid var(--primary)}
.btn-outline:hover{background:var(--primary);color:#fff}
.btn-blue{background:var(--blue);color:#fff}
.btn-blue:hover{background:var(--blue-dark)}
.navbar-actions{display:flex;align-items:center;gap:.5rem}
.hamburger{display:none;background:none;border:none;cursor:pointer;font-size:1.3rem;color:var(--gray-800)}
@media(max-width:768px){
  .navbar-nav{display:none;position:absolute;top:64px;left:0;right:0;background:#fff;flex-direction:column;padding:1rem;border-bottom:1px solid var(--gray-200);gap:.25rem;box-shadow:var(--shadow)}
  .navbar-nav.open{display:flex}
  .hamburger{display:block}
  .navbar-desktop-only{display:none}
}

/* HERO */
.hero{background:linear-gradient(135deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%);color:#fff;padding:6rem 1.5rem 5rem;position:relative;overflow:hidden;min-height:560px;display:flex;align-items:center}
.hero::before{content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")}
.hero-content{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center;position:relative;z-index:1}
.hero-badge{display:inline-flex;align-items:center;gap:.4rem;background:rgba(238,77,45,.2);color:#ff8066;padding:.3rem .8rem;border-radius:999px;font-size:.8rem;font-weight:600;margin-bottom:1.2rem;border:1px solid rgba(238,77,45,.3)}
.hero h1{font-size:clamp(2rem,4vw,3.2rem);font-weight:900;line-height:1.15;margin-bottom:1.2rem}
.hero h1 span{color:var(--primary)}
.hero p{font-size:1.1rem;color:rgba(255,255,255,.75);margin-bottom:2rem;max-width:480px}
.hero-actions{display:flex;gap:1rem;flex-wrap:wrap}
.hero-track-box{background:rgba(255,255,255,.08);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,.15);border-radius:var(--radius);padding:1.8rem;margin-top:1.5rem}
.hero-track-box h3{font-size:1rem;font-weight:700;margin-bottom:1rem;color:#fff}
.track-input-row{display:flex;gap:.5rem}
.track-input{flex:1;padding:.75rem 1rem;border:1px solid rgba(255,255,255,.2);border-radius:8px;background:rgba(255,255,255,.1);color:#fff;font-size:.95rem;font-family:inherit}
.track-input::placeholder{color:rgba(255,255,255,.5)}
.track-input:focus{outline:none;border-color:var(--primary);background:rgba(255,255,255,.15)}
.hero-right img{border-radius:var(--radius);box-shadow:0 20px 60px rgba(0,0,0,.3)}
@media(max-width:768px){.hero-content{grid-template-columns:1fr}.hero-right{display:none}}

/* STATS RIBBON */
.stats-ribbon{background:var(--primary);color:#fff;padding:1.5rem}
.stats-ribbon-inner{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;text-align:center}
.stat-item strong{font-size:1.8rem;font-weight:800;display:block}
.stat-item span{font-size:.85rem;opacity:.85}
@media(max-width:640px){.stats-ribbon-inner{grid-template-columns:repeat(2,1fr)}}

/* SECTIONS */
.section{padding:5rem 1.5rem}
.section-inner{max-width:1200px;margin:0 auto}
.section-title{text-align:center;margin-bottom:3rem}
.section-title .eyebrow{font-size:.8rem;font-weight:700;color:var(--primary);text-transform:uppercase;letter-spacing:.1em;margin-bottom:.5rem}
.section-title h2{font-size:clamp(1.6rem,3vw,2.4rem);font-weight:800;color:var(--gray-900);margin-bottom:.75rem}
.section-title p{color:var(--gray-600);max-width:520px;margin:0 auto}
.section-alt{background:var(--gray-50)}

/* CARDS */
.cards-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.5rem}
.card{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius);padding:1.8rem;transition:all .25s}
.card:hover{transform:translateY(-4px);box-shadow:var(--shadow-lg);border-color:var(--primary)}
.card-icon{width:54px;height:54px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;margin-bottom:1.2rem}
.card-icon.orange{background:var(--orange-bg);color:var(--primary)}
.card-icon.blue{background:#eff6ff;color:var(--blue)}
.card-icon.green{background:#f0fdf4;color:var(--success)}
.card-icon.purple{background:#faf5ff;color:#7c3aed}
.card h3{font-size:1rem;font-weight:700;margin-bottom:.4rem;color:var(--gray-900)}
.card p{font-size:.9rem;color:var(--gray-600)}

/* SERVICE CARDS */
.service-cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1.5rem}
.service-card{background:#fff;border:2px solid var(--gray-200);border-radius:var(--radius);padding:1.5rem;text-align:center;cursor:pointer;transition:all .2s}
.service-card:hover,.service-card.selected{border-color:var(--primary);background:var(--orange-bg)}
.service-card .badge-multiplier{background:var(--primary);color:#fff;font-size:.75rem;font-weight:700;padding:.2rem .6rem;border-radius:999px;display:inline-block;margin-bottom:.8rem}

/* TRACKING RESULT */
.track-result{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius);padding:2rem;margin-top:2rem;box-shadow:var(--shadow)}
.track-header{display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem;padding-bottom:1.5rem;border-bottom:1px solid var(--gray-200)}
.status-badge{padding:.4rem 1rem;border-radius:999px;font-size:.8rem;font-weight:700}
.status-pending{background:#fef9c3;color:#854d0e}
.status-picked_up{background:#dbeafe;color:#1e40af}
.status-in_transit{background:#dbeafe;color:#1e3a8a}
.status-arrived_at_branch{background:#ede9fe;color:#5b21b6}
.status-out_for_delivery{background:#ffedd5;color:#9a3412}
.status-delivered{background:#dcfce7;color:#166534}
.status-cancelled{background:#fee2e2;color:#991b1b}

/* TIMELINE */
.timeline{position:relative;padding-left:2rem}
.timeline::before{content:'';position:absolute;left:.55rem;top:0;bottom:0;width:2px;background:var(--gray-200)}
.timeline-item{position:relative;margin-bottom:1.5rem}
.timeline-item:last-child{margin-bottom:0}
.timeline-dot{position:absolute;left:-1.65rem;top:.25rem;width:16px;height:16px;border-radius:50%;background:var(--gray-200);border:2px solid #fff;z-index:1}
.timeline-dot.active{background:var(--primary)}
.timeline-dot.current{background:var(--primary);box-shadow:0 0 0 4px rgba(238,77,45,.2)}
.timeline-content{background:var(--gray-50);border-radius:8px;padding:.9rem 1rem}
.timeline-content strong{font-size:.9rem;font-weight:600}
.timeline-content small{color:var(--gray-600);font-size:.8rem;display:block;margin-top:.2rem}

/* FOOTER */
.footer{background:#111827;color:rgba(255,255,255,.8);padding:3rem 1.5rem 1.5rem}
.footer-inner{max-width:1200px;margin:0 auto}
.footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:2rem;margin-bottom:2rem}
.footer-brand{font-size:1.3rem;font-weight:800;color:#fff;margin-bottom:.75rem}
.footer-brand span{color:var(--primary)}
.footer-desc{font-size:.875rem;color:rgba(255,255,255,.55);line-height:1.7}
.footer h4{font-size:.9rem;font-weight:700;color:#fff;margin-bottom.75rem;margin-bottom:.75rem}
.footer ul{list-style:none}
.footer ul li{margin-bottom:.4rem}
.footer ul li a{font-size:.875rem;color:rgba(255,255,255,.55);transition:color .2s}
.footer ul li a:hover{color:var(--primary)}
.footer-bottom{border-top:1px solid rgba(255,255,255,.1);padding-top:1.2rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.5rem;font-size:.8rem;color:rgba(255,255,255,.4)}
@media(max-width:768px){.footer-grid{grid-template-columns:1fr 1fr}}
@media(max-width:480px){.footer-grid{grid-template-columns:1fr}}

/* FLASH */
.flash{position:fixed;top:80px;right:1.5rem;z-index:2000;max-width:360px;animation:slideIn .3s ease}
@keyframes slideIn{from{transform:translateX(120%);opacity:0}to{transform:translateX(0);opacity:1}}
.flash-msg{padding:.9rem 1.2rem;border-radius:10px;display:flex;align-items:center;gap:.7rem;font-size:.9rem;font-weight:500;box-shadow:var(--shadow-lg);cursor:pointer}
.flash-success{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0}
.flash-error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}

/* FORM */
.form-group{margin-bottom:1.2rem}
.form-label{display:block;font-size:.875rem;font-weight:600;color:var(--gray-700,#374151);margin-bottom:.4rem}
.form-control{width:100%;padding:.65rem .9rem;border:1.5px solid var(--gray-200);border-radius:8px;font-family:inherit;font-size:.9rem;color:var(--gray-800);transition:border-color .2s,box-shadow .2s;background:#fff}
.form-control:focus{outline:none;border-color:var(--primary);box-shadow:0 0 0 3px rgba(238,77,45,.12)}
.form-control.is-invalid{border-color:var(--danger)}
.invalid-feedback{color:var(--danger);font-size:.8rem;margin-top:.3rem}
select.form-control{cursor:pointer}
@media(max-width:768px){
    .form-row, div[style*="grid-template-columns:1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
    .navbar-desktop-only{display:none !important}
    .hero h1{font-size:2rem}
}
/* PAGINATION */
.pagination{display:flex;gap:.3rem;flex-wrap:wrap;justify-content:center;margin-top:2rem}
.page-link{padding:.45rem .8rem;border-radius:6px;border:1px solid var(--gray-200);font-size:.875rem;color:var(--gray-600);transition:all .2s}
.page-link:hover,.page-link.active{background:var(--primary);color:#fff;border-color:var(--primary)}
</style>
@stack('head')
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <a href="{{ route('home') }}" class="navbar-brand">
        <div class="logo-icon"><i class="fa fa-truck-fast"></i></div>
        Ekspedisi<span>Ku</span>
    </a>
    <div class="navbar-nav" id="nav-menu">
        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
        <a href="{{ route('tracking') }}" class="nav-link {{ request()->routeIs('tracking') ? 'active' : '' }}">Lacak Paket</a>
        <a href="{{ route('cek-ongkir') }}" class="nav-link {{ request()->routeIs('cek-ongkir') ? 'active' : '' }}">Cek Ongkir</a>
        <a href="{{ route('customer.shipments.create') }}" class="nav-link {{ request()->routeIs('customer.shipments.create') ? 'active' : '' }}">Kirim Paket</a>
    </div>
    <div class="navbar-actions">
        @auth('customer')
            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline navbar-desktop-only" style="padding:.4rem .8rem;display:flex;align-items:center;gap:.5rem">
                @if(Auth::guard('customer')->user()->photo)
                    <img src="{{ asset('storage/' . Auth::guard('customer')->user()->photo) }}" style="width:24px;height:24px;border-radius:50%;object-fit:cover">
                @else
                    <i class="fa fa-user-circle"></i>
                @endif
                {{ Auth::guard('customer')->user()->name }}
            </a>
        @elseauth('web')
            <a href="{{ url(Auth::guard('web')->user()->role === 'admin' ? '/admin/dashboard' : (Auth::guard('web')->user()->role === 'branch_admin' ? '/cabang/dashboard' : (Auth::guard('web')->user()->role === 'courier' ? '/kurir/dashboard' : '/manajer/dashboard'))) }}" class="btn btn-outline navbar-desktop-only">
                <i class="fa fa-layout"></i> Dashboard
            </a>
        @else
            <a href="{{ route('customer.login') }}" class="btn btn-outline navbar-desktop-only">
                <i class="fa fa-user"></i> Login
            </a>
            <a href="{{ route('login') }}" class="btn btn-primary navbar-desktop-only">
                <i class="fa fa-lock"></i> Staff
            </a>
        @endauth
        <button class="hamburger" onclick="document.getElementById('nav-menu').classList.toggle('open')">
            <i class="fa fa-bars"></i>
        </button>
    </div>
</nav>

<!-- FLASH MESSAGES -->
@if(session('success'))
<div class="flash"><div class="flash-msg flash-success" onclick="this.parentElement.remove()">
    <i class="fa fa-check-circle"></i> {{ session('success') }}
</div></div>
@endif
@if(session('error'))
<div class="flash"><div class="flash-msg flash-error" onclick="this.parentElement.remove()">
    <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
</div></div>
@endif

@yield('content')

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">Ekspedisi<span>Ku</span></div>
                <p class="footer-desc">Layanan pengiriman ekspedisi cepat dan terpercaya ke seluruh Indonesia. Kami berkomitmen mengantarkan paket Anda dengan aman dan tepat waktu.</p>
            </div>
            <div>
                <h4>Layanan</h4>
                <ul>
                    <li><a href="{{ route('tracking') }}">Lacak Paket</a></li>
                    <li><a href="{{ route('cek-ongkir') }}">Cek Ongkir</a></li>
                    <li><a href="{{ route('customer.register') }}">Daftar Pelanggan</a></li>
                </ul>
            </div>
            <div>
                <h4>Perusahaan</h4>
                <ul>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Cabang Kami</a></li>
                    <li><a href="#">Karir</a></li>
                </ul>
            </div>
            <div>
                <h4>Kontak</h4>
                <ul>
                    <li><a href="#">📞 021-5550001</a></li>
                    <li><a href="#">✉️ info@ekspedisiku.id</a></li>
                    <li><a href="#">📍 Jakarta, Indonesia</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© {{ date('Y') }} EkspedisiKu. Hak cipta dilindungi.</span>
            <div style="display:flex;gap:1rem">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</footer>

<script>
// Auto-dismiss flash after 4s
setTimeout(() => document.querySelectorAll('.flash').forEach(e => e.remove()), 4000);
</script>
@stack('scripts')
</body>
</html>
