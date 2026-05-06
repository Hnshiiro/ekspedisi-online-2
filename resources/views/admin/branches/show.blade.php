@extends('layouts.app')
@section('title','Detail Cabang')
@section('page-title','Detail Cabang')
@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem">
    <div class="table-card" style="padding:1.5rem">
        <h3 style="margin-bottom:1rem;font-size:1rem"><i class="fa fa-building" style="color:var(--primary)"></i> {{ $branch->name }}</h3>
        @foreach([['Kode',$branch->code],['Kota',$branch->city],['Telepon',$branch->phone??'-'],['Email',$branch->email??'-'],['Alamat',$branch->address??'-'],['Status',$branch->is_active?'Aktif':'Nonaktif']] as [$l,$v])
        <div style="display:flex;justify-content:space-between;padding:.6rem 0;border-bottom:1px solid var(--gray-100);font-size:.875rem">
            <span style="color:var(--gray-500)">{{ $l }}</span><span style="font-weight:600">{{ $v }}</span>
        </div>
        @endforeach
        <div style="margin-top:1rem;display:flex;gap:.5rem">
            <a href="{{ route('admin.branches.edit',$branch) }}" class="btn btn-secondary btn-sm"><i class="fa fa-pen"></i> Edit</a>
            <a href="{{ route('admin.branches.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
    <div class="table-card" style="padding:1.5rem">
        <h3 style="margin-bottom:1rem;font-size:1rem"><i class="fa fa-users"></i> Pengguna di Cabang Ini</h3>
        @forelse($branch->users as $u)
        <div style="display:flex;align-items:center;gap:.75rem;padding:.6rem 0;border-bottom:1px solid var(--gray-100)">
            <div style="width:32px;height:32px;border-radius:50%;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;flex-shrink:0">{{ strtoupper(substr($u->name,0,1)) }}</div>
            <div><div style="font-size:.875rem;font-weight:600">{{ $u->name }}</div><span class="badge badge-{{ $u->role }}" style="font-size:.7rem">{{ ucwords(str_replace('_',' ',$u->role)) }}</span></div>
        </div>
        @empty<p style="color:var(--gray-400);font-size:.875rem">Tidak ada pengguna.</p>@endforelse
    </div>
</div>
@endsection
