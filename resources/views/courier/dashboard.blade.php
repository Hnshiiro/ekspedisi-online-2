@extends('layouts.app')
@section('title','Dashboard Kurir')
@section('page-title','Selamat bertugas, ' . $user->name . '! (' . ($user->branch->name ?? 'Pusat') . ')')
@section('breadcrumb','Dashboard')

@section('content')
<div class="stats-grid">
    @foreach([
        ['label'=>'Tugas Aktif (Menunggu)','value'=>$assignedShipments->count(),'icon'=>'fa-box','class'=>'orange'],
        ['label'=>'Terkirim Hari Ini','value'=>$deliveredToday,'icon'=>'fa-check-circle','class'=>'green'],
        ['label'=>'Total Kiriman Selesai','value'=>$totalDelivered,'icon'=>'fa-trophy','class'=>'purple'],
    ] as $s)
    <div class="stat-card">
        <div class="stat-icon {{ $s['class'] }}"><i class="fa {{ $s['icon'] }}"></i></div>
        <div><div class="stat-value">{{ number_format($s['value']) }}</div><div class="stat-label">{{ $s['label'] }}</div></div>
    </div>
    @endforeach
</div>

<div class="table-card" style="margin-top:1.5rem">
    <div class="table-card-header"><h3><i class="fa fa-truck-fast" style="color:var(--primary)"></i> Daftar Tugas Pengiriman Saat Ini</h3></div>
    <div class="table-responsive">
        <table>
            <thead><tr><th>Resi</th><th>Penerima</th><th>Alamat Penerima</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($assignedShipments as $s)
            <tr>
                <td><span style="font-family:monospace;font-weight:600;font-size:.85rem;color:var(--primary)">{{ $s->tracking_number }}</span></td>
                <td>
                    {{ $s->receiver_name ?? ($s->receiver?->name ?? '-') }}<br>
                    <small style="color:var(--gray-500)">{{ $s->receiver_phone ?? ($s->receiver?->phone ?? '') }}</small>
                </td>
                <td style="max-width:300px;font-size:.8rem">{{ $s->receiver_address }}</td>
                <td><span class="badge badge-{{ $s->status }}">{{ $s->status_label }}</span></td>
                <td><button onclick="openUpdateModal('{{ $s->id }}','{{ $s->tracking_number }}','{{ $s->status }}')" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Update</button></td>
            </tr>
            @empty
            <tr><td colspan="5"><div class="empty-state"><i class="fa fa-mug-hot"></i><h3>Belum ada tugas</h3><p>Tidak ada pengiriman aktif yang ditugaskan kepada Anda saat ini.</p></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<dialog id="update-modal" style="border:none;border-radius:16px;padding:0;max-width:400px;width:95%;box-shadow:var(--shadow-lg)">
    <div style="padding:1.5rem">
        <h3 style="margin-bottom:1rem;font-size:1rem">Update Status: <span id="modal-resi" style="color:var(--primary);font-family:monospace"></span></h3>
        <form id="update-form" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Ubah Status Menjadi</label>
                <select name="status" id="modal-status" class="form-control" required>
                    <option value="picked_up">Sudah Diambil (Pick Up)</option>
                    <option value="in_transit">Dalam Perjalanan (Transit)</option>
                    <option value="arrived_at_branch">Tiba di Cabang</option>
                    <option value="out_for_delivery">Dalam Pengantaran ke Penerima</option>
                    <option value="delivered">Berhasil Terkirim</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Keterangan / Posisi Saat Ini</label>
                <textarea name="description" class="form-control" rows="2" placeholder="cth. Diterima oleh Bapak Budi (Satpam)"></textarea>
            </div>
            <div style="display:flex;gap:.5rem">
                <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center">Simpan</button>
                <button type="button" onclick="document.getElementById('update-modal').close()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</dialog>
@push('scripts')
<script>
function openUpdateModal(id, resi, currentStatus) {
    document.getElementById('modal-resi').innerText = resi;
    document.getElementById('update-form').action = `/kurir/pengiriman/${id}/status`;
    document.getElementById('modal-status').value = currentStatus;
    document.getElementById('update-modal').showModal();
}
</script>
@endpush
@endsection
