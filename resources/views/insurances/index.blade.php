@extends('layouts.preclinic-app')

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Manajemen Asuransi</h3>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="card-title mb-0">Daftar Asuransi</h5>
        <a href="{{ route('insurances.create') }}" class="btn btn-primary">Tambah Asuransi</a>
    </div>
    <div class="card-body">
        <form class="row mb-3" method="GET" action="{{ route('insurances.index') }}">
            <div class="col-md-4">
                <input type="text" name="q" class="form-control" placeholder="Cari nama..." value="{{ request('q') }}">
            </div>
            <div class="col-md-3">
                <select name="type" class="form-control">
                    <option value="">-- Semua Tipe --</option>
                    @foreach($types as $t)
                        <option value="{{ $t }}" @selected(request('type') === $t)>{{ strtoupper($t) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-primary w-100" type="submit">Filter</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Kontak</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($insurances as $insurance)
                        <tr>
                            <td>{{ $insurance->name }}</td>
                            <td>{{ strtoupper($insurance->type) }}</td>
                            <td>{{ Str::limit($insurance->contact_info, 40) }}</td>
                            <td>
                                @if($insurance->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('insurances.edit', $insurance) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('insurances.destroy', $insurance) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus asuransi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Belum ada data asuransi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $insurances->links() }}
        </div>
    </div>
</div>
@endsection

