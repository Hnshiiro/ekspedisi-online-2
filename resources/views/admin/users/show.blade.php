@extends('layouts.app')
@section('title','Detail Pengguna')
@section('page-title','Detail Pengguna')
@section('content')
<div style="max-width:560px">
<div class="table-card" style="padding:1.5rem">
    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;padding-bottom:1.5rem;border-bottom:1px solid var(--gray-100)">
        <div style="width:56px;height:56px;border-radius:50%;background:var(--primary);color:#fff;font-size:1.3rem;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0">{{ strtoupper(substr($user->name,0,1)) }}</div>
        <div>
            <h3 style="font-size:1.1rem;font-weight:700">{{ $user->name }}</h3>
            <span class="badge badge-{{ $user->role }}">{{ ucwords(str_replace('_',' ',$user->role)) }}</span>
        </div>
    </div>
    @foreach([['Email',$user->email],['Telepon',$user->phone??'-'],['Cabang',$user->branch?->name??'-'],['Status',$user->is_active?'Aktif':'Nonaktif'],['Bergabung',optional($user->created_at)->format('d M Y')]] as [$l,$v])
    <div style="display:flex;justify-content:space-between;padding:.55rem 0;border-bottom:1px solid var(--gray-100);font-size:.875rem">
        <span style="color:var(--gray-500)">{{ $l }}</span><span style="font-weight:600">{{ $v }}</span>
    </div>
    @endforeach
    <div style="margin-top:1rem;display:flex;gap:.5rem">
        <a href="{{ route('admin.users.edit',$user) }}" class="btn btn-secondary btn-sm"><i class="fa fa-pen"></i> Edit</a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
</div>
</div>
@endsection
