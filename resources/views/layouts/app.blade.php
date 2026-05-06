<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title','Dashboard') | EkspedisiKu</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --primary:#EE4D2D;--primary-dark:#C73E22;--primary-light:#ff6b4a;
  --orange-bg:#FFF3F0;--sidebar-bg:#1a1a2e;--sidebar-text:rgba(255,255,255,.75);
  --sidebar-active:#EE4D2D;--sidebar-hover:rgba(255,255,255,.08);
  --gray-50:#f9fafb;--gray-100:#f3f4f6;--gray-200:#e5e7eb;
  --gray-400:#9ca3af;--gray-600:#4b5563;--gray-800:#1f2937;
  --success:#16a34a;--warning:#d97706;--danger:#dc2626;--info:#0891b2;
  --radius:12px;--radius-sm:8px;--shadow:0 4px 24px rgba(0,0,0,.08);
}
html{height:100%}
body{font-family:'Inter',sans-serif;color:var(--gray-800);background:var(--gray-50);display:flex;min-height:100vh}

/* ── SIDEBAR ── */
.sidebar{width:260px;min-height:100vh;background:var(--sidebar-bg);display:flex;flex-direction:column;position:fixed;left:0;top:0;z-index:200;transition:transform .3s}
.sidebar-brand{padding:1.5rem 1.2rem;border-bottom:1px solid rgba(255,255,255,.1);display:flex;align-items:center;gap:.7rem}
.sidebar-brand-logo{width:36px;height:36px;background:var(--primary);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.1rem;flex-shrink:0}
.sidebar-brand-name{font-size:1.2rem;font-weight:800;color:#fff}
.sidebar-brand-name span{color:var(--primary)}
.sidebar-user{padding:1rem 1.2rem;border-bottom:1px solid rgba(255,255,255,.08)}
.sidebar-user:hover{background:rgba(255,255,255,.05)}
.sidebar-user-avatar{width:36px;height:36px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.9rem;flex-shrink:0}
.sidebar-user-info{display:flex;align-items:center;gap:.7rem}
.sidebar-user-name{font-size:.875rem;font-weight:600;color:#fff;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.sidebar-user-role{font-size:.75rem;color:rgba(255,255,255,.45);margin-top:.1rem}
.sidebar-nav{flex:1;padding:.75rem .75rem;overflow-y:auto}
.sidebar-section{font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.3);padding:.4rem .6rem;margin-top:1rem;margin-bottom:.25rem}
.sidebar-link{display:flex;align-items:center;gap:.75rem;padding:.65rem .75rem;border-radius:8px;color:var(--sidebar-text);font-size:.875rem;font-weight:500;transition:all .2s;cursor:pointer;text-decoration:none}
.sidebar-link:hover{background:var(--sidebar-hover);color:#fff}
.sidebar-link.active{background:var(--primary);color:#fff;font-weight:600}
.sidebar-link .icon{width:18px;text-align:center;font-size:.9rem}
.sidebar-footer{padding:1rem;border-top:1px solid rgba(255,255,255,.1)}

/* ── MAIN ── */
.main-wrapper{margin-left:260px;flex:1;min-height:100vh;display:flex;flex-direction:column}
.topbar{height:60px;background:#fff;border-bottom:1px solid var(--gray-200);display:flex;align-items:center;justify-content:space-between;padding:0 1.5rem;position:sticky;top:0;z-index:100;box-shadow:0 2px 8px rgba(0,0,0,.04)}
.topbar-left{display:flex;align-items:center;gap:1rem}
.topbar-title{font-size:1rem;font-weight:700;color:var(--gray-800)}
.breadcrumb{display:flex;align-items:center;gap:.4rem;font-size:.8rem;color:var(--gray-400)}
.breadcrumb a{color:var(--gray-400);text-decoration:none}
.breadcrumb a:hover{color:var(--primary)}
.topbar-right{display:flex;align-items:center;gap.75rem;gap:.75rem}
.topbar-btn{padding:.4rem .75rem;border-radius:8px;border:1px solid var(--gray-200);background:#fff;font-size:.875rem;font-weight:500;cursor:pointer;display:flex;align-items:center;gap:.4rem;color:var(--gray-600);transition:all .2s}
.topbar-btn:hover{background:var(--gray-100);border-color:var(--gray-300,#d1d5db)}
.page-content{flex:1;padding:1.5rem}
@media(max-width:1024px){
  .sidebar{transform:translateX(-100%)}
  .sidebar.open{transform:translateX(0)}
  .main-wrapper{margin-left:0}
}

/* ── COMPONENTS ── */
.btn{display:inline-flex;align-items:center;gap:.4rem;padding:.55rem 1.1rem;border-radius:8px;font-size:.875rem;font-weight:600;cursor:pointer;border:none;transition:all .2s;text-decoration:none}
.btn-primary{background:var(--primary);color:#fff}.btn-primary:hover{background:var(--primary-dark);transform:translateY(-1px);box-shadow:0 4px 12px rgba(238,77,45,.3)}
.btn-secondary{background:var(--gray-100);color:var(--gray-800);border:1px solid var(--gray-200)}.btn-secondary:hover{background:var(--gray-200)}
.btn-success{background:var(--success);color:#fff}.btn-success:hover{filter:brightness(.9)}
.btn-danger{background:var(--danger);color:#fff}.btn-danger:hover{filter:brightness(.9)}
.btn-info{background:var(--info);color:#fff}.btn-info:hover{filter:brightness(.9)}
.btn-sm{padding:.35rem .75rem;font-size:.8rem}
.btn-outline{background:transparent;border:1.5px solid var(--primary);color:var(--primary)}.btn-outline:hover{background:var(--primary);color:#fff}

/* CARDS */
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1.2rem;margin-bottom:1.5rem}
.stat-card{background:#fff;border-radius:var(--radius);padding:1.4rem;box-shadow:var(--shadow);border:1px solid var(--gray-100);display:flex;align-items:flex-start;gap:1rem;transition:transform .2s}
.stat-card:hover{transform:translateY(-2px)}
.stat-icon{width:48px;height:48px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0}
.stat-icon.orange{background:var(--orange-bg);color:var(--primary)}
.stat-icon.blue{background:#eff6ff;color:#2563eb}
.stat-icon.green{background:#f0fdf4;color:var(--success)}
.stat-icon.purple{background:#faf5ff;color:#7c3aed}
.stat-icon.yellow{background:#fffbeb;color:var(--warning)}
.stat-icon.red{background:#fef2f2;color:var(--danger)}
.stat-icon.teal{background:#f0fdfa;color:#0d9488}
.stat-value{font-size:1.8rem;font-weight:800;color:var(--gray-900);line-height:1}
.stat-label{font-size:.8rem;color:var(--gray-600);margin-top:.3rem}
.stat-change{font-size:.75rem;margin-top:.25rem}
.stat-change.up{color:var(--success)}.stat-change.down{color:var(--danger)}

/* TABLE */
.table-card{background:#fff;border-radius:var(--radius);box-shadow:var(--shadow);border:1px solid var(--gray-100);overflow:hidden}
.table-card-header{padding:1.2rem 1.5rem;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--gray-100);flex-wrap:wrap;gap:.75rem}
.table-card-header h3{font-size:1rem;font-weight:700;color:var(--gray-900)}
.table-responsive{overflow-x:auto}
table{width:100%;border-collapse:collapse}
th{padding:.8rem 1rem;text-align:left;font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--gray-400);background:var(--gray-50);border-bottom:1px solid var(--gray-100)}
td{padding:.9rem 1rem;border-bottom:1px solid var(--gray-100);font-size:.875rem;color:var(--gray-800);vertical-align:middle}
tr:last-child td{border-bottom:none}
tr:hover td{background:var(--gray-50)}

/* BADGES */
.badge{display:inline-flex;align-items:center;gap:.25rem;padding:.3rem .75rem;border-radius:999px;font-size:.75rem;font-weight:700}
.badge-pending{background:#fef9c3;color:#854d0e}
.badge-picked_up{background:#dbeafe;color:#1e40af}
.badge-in_transit,.badge-in-transit{background:#e0f2fe;color:#0369a1}
.badge-arrived_at_branch{background:#ede9fe;color:#5b21b6}
.badge-out_for_delivery{background:#ffedd5;color:#9a3412}
.badge-delivered{background:#dcfce7;color:#166534}
.badge-cancelled{background:#fee2e2;color:#991b1b}
.badge-paid{background:#dcfce7;color:#166534}
.badge-unpaid{background:#fee2e2;color:#991b1b}
.badge-partial{background:#fef9c3;color:#854d0e}
.badge-available{background:#dcfce7;color:#166534}
.badge-in_use{background:#dbeafe;color:#1e40af}
.badge-maintenance{background:#fee2e2;color:#991b1b}
.badge-admin{background:#ede9fe;color:#5b21b6}
.badge-branch_admin{background:#dbeafe;color:#1e40af}
.badge-courier{background:#dcfce7;color:#166534}
.badge-manager{background:#fef9c3;color:#854d0e}
.badge-active{background:#dcfce7;color:#166534}
.badge-inactive{background:#fee2e2;color:#991b1b}

/* FORM */
.form-card{background:#fff;border-radius:var(--radius);box-shadow:var(--shadow);border:1px solid var(--gray-100);overflow:hidden}
.form-card-header{padding:1.2rem 1.5rem;border-bottom:1px solid var(--gray-100)}
.form-card-header h3{font-size:1rem;font-weight:700}
.form-card-body{padding:1.5rem}
.form-group{margin-bottom:1.2rem}
.form-label{display:block;font-size:.8rem;font-weight:700;color:var(--gray-600);margin-bottom:.4rem;text-transform:uppercase;letter-spacing:.03em}
.form-control{width:100%;padding:.65rem .9rem;border:1.5px solid var(--gray-200);border-radius:8px;font-family:inherit;font-size:.9rem;color:var(--gray-800);transition:all .2s;background:#fff}
.form-control:focus{outline:none;border-color:var(--primary);box-shadow:0 0 0 3px rgba(238,77,45,.1)}
.form-control.is-invalid{border-color:var(--danger)}
.invalid-feedback{color:var(--danger);font-size:.78rem;margin-top:.3rem;display:block}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
@media(max-width:600px){.form-row{grid-template-columns:1fr}}
.form-footer{padding:1.2rem 1.5rem;border-top:1px solid var(--gray-100);display:flex;gap:.75rem;flex-wrap:wrap}

/* FLASH */
.flash{position:fixed;top:72px;right:1.5rem;z-index:3000;max-width:360px;animation:slideIn .3s ease}
@keyframes slideIn{from{transform:translateX(120%);opacity:0}to{transform:translateX(0);opacity:1}}
.flash-msg{padding:.9rem 1.2rem;border-radius:10px;display:flex;align-items:center;gap:.7rem;font-size:.875rem;font-weight:500;box-shadow:var(--shadow);cursor:pointer}
.flash-success{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0}
.flash-error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}

/* PAGINATION */
.pagination{display:flex;gap:.3rem;flex-wrap:wrap;padding:1rem 1.5rem;border-top:1px solid var(--gray-100)}
.page-link{padding:.45rem .8rem;border-radius:6px;border:1px solid var(--gray-200);font-size:.8rem;color:var(--gray-600);transition:all .2s;text-decoration:none}
.page-link:hover,.page-link.active{background:var(--primary);color:#fff;border-color:var(--primary)}
.page-link.disabled{opacity:.45;pointer-events:none}

/* EMPTY STATE */
.empty-state{text-align:center;padding:4rem 2rem}
.empty-state i{font-size:3rem;color:var(--gray-200);margin-bottom:1rem}
.empty-state h3{font-size:1.1rem;font-weight:700;color:var(--gray-600);margin-bottom:.5rem}
.empty-state p{color:var(--gray-400);font-size:.9rem}

/* TOGGLE SIDEBAR */
.sidebar-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:199}
@media(max-width:1024px){
  .sidebar{transform:translateX(-100%)}
  .sidebar.open{transform:translateX(0)}
  .main-wrapper{margin-left:0}
  .sidebar-overlay.open{display:block}
  #mobile-toggle{display:flex !important}
  .topbar{padding:0 1rem}
  .page-content{padding:1rem}
  .stats-grid{grid-template-columns:1fr 1fr}
  .form-row{grid-template-columns:1fr}
}
@media(max-width:600px){
  .stats-grid{grid-template-columns:1fr}
  .topbar-btn span{display:none}
}
</style>
@stack('head')
</head>
<body>

<!-- Overlay for mobile -->
<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-brand-logo"><i class="fa fa-truck-fast"></i></div>
        <div class="sidebar-brand-name">Ekspedisi<span>Ku</span></div>
    </div>
    <a href="{{ route('profile') }}" class="sidebar-user" style="text-decoration:none;display:block;transition:all .2s;cursor:pointer">
        <div class="sidebar-user-info">
            @if(Auth::guard('web')->user()->photo)
                <img src="{{ asset('storage/' . Auth::guard('web')->user()->photo) }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;flex-shrink:0;border:2px solid rgba(255,255,255,.1)">
            @else
                <div class="sidebar-user-avatar">{{ strtoupper(substr(Auth::guard('web')->user()->name ?? 'U', 0, 1)) }}</div>
            @endif
            <div>
                <div class="sidebar-user-name">{{ Auth::guard('web')->user()->name ?? '' }}</div>
                <div class="sidebar-user-role">{{ ucwords(str_replace('_',' ', Auth::guard('web')->user()->role ?? '')) }}</div>
            </div>
            <div style="margin-left:auto;color:rgba(255,255,255,.2);font-size:.7rem"><i class="fa fa-chevron-right"></i></div>
        </div>
    </a>
    <nav class="sidebar-nav">
        @php $role = Auth::guard('web')->user()->role ?? '' @endphp

        @if($role === 'admin')
            <div class="sidebar-section">Dashboard</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-gauge"></i></span> Dashboard
            </a>
            <div class="sidebar-section">Master Data</div>
            <a href="{{ route('admin.branches.index') }}" class="sidebar-link {{ request()->routeIs('admin.branches.*') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-building"></i></span> Cabang
            </a>
            <a href="{{ route('admin.couriers.index') }}" class="sidebar-link {{ request()->routeIs('admin.couriers.*') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-truck-ramp-box"></i></span> Kurir
            </a>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-users"></i></span> Pengguna
            </a>
            <a href="{{ route('admin.customers.index') }}" class="sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-user-group"></i></span> Pelanggan
            </a>
            <a href="{{ route('admin.vehicles.index') }}" class="sidebar-link {{ request()->routeIs('admin.vehicles.*') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-truck"></i></span> Kendaraan
            </a>
            <a href="{{ route('admin.services.index') }}" class="sidebar-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-layer-group"></i></span> Layanan
            </a>
            <a href="{{ route('admin.routes.index') }}" class="sidebar-link {{ request()->routeIs('admin.routes.*') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-route"></i></span> Rute
            </a>
            <div class="sidebar-section">Operasional</div>
            <a href="{{ route('admin.shipments.index') }}" class="sidebar-link {{ request()->routeIs('admin.shipments.*') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-box"></i></span> Pengiriman
            </a>
            <a href="{{ route('admin.payments.index') }}" class="sidebar-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-credit-card"></i></span> Pembayaran
            </a>
            <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-chart-bar"></i></span> Laporan
            </a>
        @elseif($role === 'branch_admin')
            <a href="{{ route('branch.dashboard') }}" class="sidebar-link {{ request()->routeIs('branch.dashboard') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-gauge"></i></span> Dashboard
            </a>
            <a href="{{ route('branch.shipments.index') }}" class="sidebar-link {{ request()->routeIs('branch.shipments.*') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-box"></i></span> Pengiriman
            </a>
            <a href="{{ route('branch.vehicles.index') }}" class="sidebar-link {{ request()->routeIs('branch.vehicles.*') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-truck"></i></span> Kendaraan
            </a>
        @elseif($role === 'courier')
            <a href="{{ route('courier.dashboard') }}" class="sidebar-link {{ request()->routeIs('courier.dashboard') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-gauge"></i></span> Dashboard
            </a>
            <a href="{{ route('courier.shipments') }}" class="sidebar-link {{ request()->routeIs('courier.shipments') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-box"></i></span> Kiriman Saya
            </a>
        @elseif($role === 'manager')
            <a href="{{ route('manager.dashboard') }}" class="sidebar-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-gauge"></i></span> Dashboard
            </a>
            <a href="{{ route('manager.shipments') }}" class="sidebar-link {{ request()->routeIs('manager.shipments') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-box"></i></span> Semua Pengiriman
            </a>
            <a href="{{ route('manager.reports') }}" class="sidebar-link {{ request()->routeIs('manager.reports') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-chart-bar"></i></span> Laporan
            </a>
        @endif
    </nav>
    <div class="sidebar-footer">
        <a href="{{ route('home') }}" class="sidebar-link" style="margin-bottom:.4rem">
            <span class="icon"><i class="fa fa-globe"></i></span> Halaman Utama
        </a>
    </div>
</aside>

<!-- MAIN -->
<div class="main-wrapper">
    <div class="topbar">
        <div class="topbar-left">
            <button class="topbar-btn" onclick="toggleSidebar()" style="display:none;padding:.5rem" id="mobile-toggle">
                <i class="fa fa-bars"></i>
            </button>
            <div style="margin-left:.5rem">
                <div class="topbar-title">@yield('page-title','Dashboard')</div>
                <div class="breadcrumb">
                    <a href="{{ route('home') }}">Beranda</a> / @yield('breadcrumb','Dashboard')
                </div>
            </div>
        </div>
        <div class="topbar-right">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="topbar-btn" style="color:var(--danger);border-color:rgba(220,38,38,.2);cursor:pointer">
                    <i class="fa fa-power-off"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Flash -->
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

    <main class="page-content">
        @yield('content')
    </main>
</div>

<script>
function toggleSidebar(){
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('overlay').classList.toggle('open');
}
function closeSidebar(){
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('overlay').classList.remove('open');
}
setTimeout(() => document.querySelectorAll('.flash').forEach(e => e.remove()), 4000);
</script>
@stack('scripts')
</body>
</html>
