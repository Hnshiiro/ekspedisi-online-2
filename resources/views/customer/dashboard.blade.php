@extends('layouts.landing')
@section('title','Dashboard Pelanggan')
@section('content')
<div style="background:var(--gray-50);min-height:80vh;padding:3rem 1.5rem">
    <div style="max-width:1200px;margin:0 auto;display:grid;grid-template-columns:260px 1fr;gap:2rem;align-items:start">

        <!-- Sidebar Pelanggan -->
        <div style="background:#fff;border-radius:16px;border:1px solid var(--gray-200);overflow:hidden;position:sticky;top:84px">
            <div style="padding:1.5rem;text-align:center;border-bottom:1px solid var(--gray-100)">
                @if(auth()->guard('customer')->user()->photo)
                    <img src="{{ asset('storage/' . auth()->guard('customer')->user()->photo) }}" style="width:64px;height:64px;border-radius:50%;object-fit:cover;margin:0 auto .75rem;display:block;border:3px solid var(--orange-bg)">
                @else
                    <div style="width:64px;height:64px;border-radius:50%;background:var(--orange-bg);color:var(--primary);font-size:1.5rem;font-weight:800;display:flex;align-items:center;justify-content:center;margin:0 auto .75rem">{{ strtoupper(substr(auth()->guard('customer')->user()->name,0,1)) }}</div>
                @endif
                <div style="font-weight:700;font-size:1.1rem;color:var(--gray-900)">{{ auth()->guard('customer')->user()->name }}</div>
                <div style="font-size:.8rem;color:var(--gray-500)">{{ auth()->guard('customer')->user()->email }}</div>
            </div>
            <div style="padding:.75rem">
                <a href="{{ route('customer.dashboard') }}" class="btn {{ request()->routeIs('customer.dashboard')?'btn-primary':'btn-secondary' }}" style="width:100%;justify-content:flex-start;margin-bottom:.4rem;background:{{ request()->routeIs('customer.dashboard')?'':'transparent' }};border:none"><i class="fa fa-gauge" style="width:20px"></i> Dashboard</a>
                <a href="{{ route('customer.shipments') }}" class="btn {{ request()->routeIs('customer.shipments')?'btn-primary':'btn-secondary' }}" style="width:100%;justify-content:flex-start;margin-bottom:.4rem;background:{{ request()->routeIs('customer.shipments')?'':'transparent' }};border:none"><i class="fa fa-box" style="width:20px"></i> Kiriman Saya</a>
                <a href="{{ route('customer.track') }}" class="btn {{ request()->routeIs('customer.track')?'btn-primary':'btn-secondary' }}" style="width:100%;justify-content:flex-start;margin-bottom:.4rem;background:{{ request()->routeIs('customer.track')?'':'transparent' }};border:none"><i class="fa fa-magnifying-glass" style="width:20px"></i> Lacak Paket</a>
                <a href="{{ route('customer.profile') }}" class="btn {{ request()->routeIs('customer.profile')?'btn-primary':'btn-secondary' }}" style="width:100%;justify-content:flex-start;margin-bottom:.4rem;background:{{ request()->routeIs('customer.profile')?'':'transparent' }};border:none"><i class="fa fa-user-gear" style="width:20px"></i> Pengaturan Profil</a>
                <form action="{{ route('customer.logout') }}" method="POST">@csrf<button class="btn" style="width:100%;justify-content:flex-start;background:transparent;color:var(--danger)"><i class="fa fa-right-from-bracket" style="width:20px"></i> Logout</button></form>
            </div>
        </div>

        <!-- Content -->
        <div>
            @yield('customer-content')
            @if(request()->routeIs('customer.dashboard'))
            <h2 style="font-size:1.4rem;font-weight:800;margin-bottom:1.5rem">Halo, {{ explode(' ',auth()->guard('customer')->user()->name)[0] }}! 👋</h2>

            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:2rem">
                <div style="background:#fff;border-radius:12px;padding:1.5rem;border:1px solid var(--gray-200);box-shadow:var(--shadow)">
                    <div style="font-size:2rem;color:var(--primary);margin-bottom:.5rem"><i class="fa fa-paper-plane"></i></div>
                    <div style="font-size:2rem;font-weight:800;line-height:1">{{ $totalSent }}</div>
                    <div style="font-size:.875rem;color:var(--gray-500);margin-top:.3rem">Paket Dikirim</div>
                </div>
                <div style="background:#fff;border-radius:12px;padding:1.5rem;border:1px solid var(--gray-200);box-shadow:var(--shadow)">
                    <div style="font-size:2rem;color:var(--blue);margin-bottom:.5rem"><i class="fa fa-inbox"></i></div>
                    <div style="font-size:2rem;font-weight:800;line-height:1">{{ $totalReceived }}</div>
                    <div style="font-size:.875rem;color:var(--gray-500);margin-top:.3rem">Paket Diterima</div>
                </div>
                <div style="background:#fff;border-radius:12px;padding:1.5rem;border:1px solid var(--gray-200);box-shadow:var(--shadow)">
                    <div style="font-size:2rem;color:var(--warning);margin-bottom:.5rem"><i class="fa fa-truck-fast"></i></div>
                    <div style="font-size:2rem;font-weight:800;line-height:1">{{ $inProgress }}</div>
                    <div style="font-size:.875rem;color:var(--gray-500);margin-top:.3rem">Sedang Proses</div>
                </div>
            </div>

            <div style="background:#fff;border-radius:16px;border:1px solid var(--gray-200);box-shadow:var(--shadow);overflow:hidden">
                <div style="padding:1.2rem 1.5rem;border-bottom:1px solid var(--gray-100);display:flex;justify-content:space-between;align-items:center">
                    <h3 style="font-size:1rem;font-weight:700">Kiriman Terbaru</h3>
                    <a href="{{ route('customer.shipments') }}" style="font-size:.875rem;color:var(--primary);font-weight:600">Lihat Semua</a>
                </div>
                <div>
                    @forelse($myShipments as $s)
                    <div style="padding:1.2rem 1.5rem;border-bottom:1px solid var(--gray-100);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem">
                        <div style="display:flex;gap:1rem;align-items:center">
                            <div style="width:48px;height:48px;border-radius:12px;background:var(--gray-50);display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:{{ $s->sender_id==auth()->guard('customer')->user()->id ? 'var(--primary)' : 'var(--blue)' }}">
                                <i class="fa {{ $s->sender_id==auth()->guard('customer')->user()->id ? 'fa-paper-plane' : 'fa-inbox' }}"></i>
                            </div>
                            <div>
                                <div style="font-family:monospace;font-weight:700;font-size:.95rem">{{ $s->tracking_number }}</div>
                                <div style="font-size:.8rem;color:var(--gray-500);margin-top:.2rem">{{ $s->origin_city }} → {{ $s->destination_city }}</div>
                            </div>
                        </div>
                        <div style="text-align:right">
                            <span class="status-badge status-{{ $s->status }}">{{ $s->status_label }}</span>
                            <div style="margin-top:.4rem"><a href="{{ route('customer.track') }}?no={{ $s->tracking_number }}" style="font-size:.8rem;color:var(--primary);font-weight:600">Lacak <i class="fa fa-arrow-right"></i></a></div>
                        </div>
                    </div>
                    @empty
                    <div style="padding:3rem 1.5rem;text-align:center;color:var(--gray-400)">
                        <i class="fa fa-box-open" style="font-size:2.5rem;margin-bottom:1rem"></i>
                        <p>Belum ada kiriman.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<style>
@media(max-width:768px){
    div[style*="grid-template-columns:260px 1fr"] {
        grid-template-columns: 1fr !important;
        gap: 1rem !important;
        padding: 1rem .5rem !important;
    }
    div[style*="position:sticky"] {
        position: static !important;
    }
    div[style*="grid-template-columns:repeat(3,1fr)"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection
