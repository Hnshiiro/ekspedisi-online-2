@extends('layouts.app')

@section('title', 'Detail Cabang - ' . $branch->name)

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2>{{ $branch->name }}</h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('branches.edit', $branch) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('branches.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="150">Kode Cabang</th>
                        <td>{{ $branch->code }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $branch->name }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $branch->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $branch->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $branch->address ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kota</th>
                        <td>{{ $branch->city ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Provinsi</th>
                        <td>{{ $branch->province ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($branch->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Dibuat</th>
                        <td>{{ $branch->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
