@extends('layouts.app')
@section('title','Semua Kiriman Saya')
@section('page-title','Semua Kiriman Saya')
@section('breadcrumb','Kiriman Saya')

@section('content')
<div class="table-card">
    <div class="table-card-header"><h3><i class="fa fa-box" style="color:var(--primary)"></i> Riwayat Kiriman</h3></div>
    <div class="table-responsive">
        <table>
            <thead><tr><th>Tanggal</th><th>Resi</th><th>Penerima</th><th>Alamat</th><th>Status Akhir</th></tr></thead>
            <tbody>
            @forelse($shipments as $s)
            <tr>
                <td style="font-size:.85rem;color:var(--gray-600)">{{ $s->created_at->format('d M Y') }}</td>
                <td><span style="font-family:monospace;font-weight:600;font-size:.85rem;color:var(--primary)">{{ $s->tracking_number }}</span></td>
                <td>{{ $s->receiver_name ?? ($s->receiver?->name ?? '-') }}</td>
                <td style="max-width:300px;font-size:.8rem">{{ $s->receiver_address }}</td>
                <td><span class="badge badge-{{ $s->status }}">{{ $s->status_label }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5"><div class="empty-state"><i class="fa fa-box"></i><h3>Belum ada riwayat</h3></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($shipments->hasPages())<div class="pagination">{{ $shipments->links() }}</div>@endif
</div>
@endsection
