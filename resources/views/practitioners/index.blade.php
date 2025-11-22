@extends('layouts.preclinic-app')

@section('content')
<div class="row">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Manajemen User</h4>
    </div>
    <div class="col-sm-8 col-9 text-right m-b-20">
        <a href="{{ route('practitioners.create') }}" class="btn btn-primary float-right btn-rounded"><i class="fa fa-plus"></i> Tambah User</a>
    </div>
</div>
<div class="row filter-row">
    <form method="GET" action="{{ route('practitioners.index') }}" class="w-100">
        <div class="col-sm-6 col-md-3">
            <div class="form-group form-focus">
                <label class="focus-label">Cari (Nama/Email/Role)</label>
                <input type="text" name="q" class="form-control floating" value="{{ request('q') }}" placeholder="Cari...">
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="form-group form-focus select-focus">
                <label class="focus-label">Role</label>
                <select class="select floating" name="role">
                    <option value="">Semua Role</option>
                    @foreach($practitionerRoles as $roleValue)
                        <option value="{{ $roleValue }}" {{ request('role') == $roleValue ? 'selected' : '' }}>{{ ucfirst($roleValue) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <button type="submit" class="btn btn-success btn-block"> <i class="fa fa-search"></i> Cari </button>
        </div>
        <div class="col-sm-6 col-md-3">
            <a href="{{ route('practitioners.index') }}" class="btn btn-secondary btn-block">Reset</a>
        </div>
    </form>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th style="min-width:200px;">Nama</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status Aktif</th>
                        <th style="min-width: 110px;">Tanggal Dibuat</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($practitioners as $index => $practitioner)
                    <tr>
                        <td>{{ $practitioners->firstItem() + $index }}</td>
                        <td>
                            <h2>{{ $practitioner->full_name }}</h2>
                            @if($practitioner->identifier)
                                <small class="text-muted">ID: {{ $practitioner->identifier }}</small>
                            @endif
                        </td>
                        <td>
                            @php
                                $userRole = $practitioner->roles->first();
                            @endphp
                            @if($userRole)
                                <span class="custom-badge status-blue">{{ $userRole->name }}</span>
                            @else
                                <span class="custom-badge status-grey">{{ $practitioner->role ?? '-' }}</span>
                            @endif
                        </td>
                        <td>{{ $practitioner->email ?? '-' }}</td>
                        <td>{{ $practitioner->phone ?? '-' }}</td>
                        <td>
                            @if($practitioner->is_active)
                                <span class="custom-badge status-green">Aktif</span>
                            @else
                                <span class="custom-badge status-red">Nonaktif</span>
                            @endif
                        </td>
                        <td>{{ $practitioner->created_at->format('d-m-Y H:i') }}</td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('practitioners.edit', $practitioner->id) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <form method="POST" action="{{ route('practitioners.toggle-status', $practitioner->id) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item" onclick="return confirm('Yakin ingin mengubah status user ini?')">
                                            <i class="fa fa-toggle-{{ $practitioner->is_active ? 'off' : 'on' }} m-r-5"></i> 
                                            {{ $practitioner->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data user ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{ $practitioners->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection

