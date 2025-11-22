@extends('layouts.preclinic-app')

@section('content')
<div class="row">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Manajemen Role</h4>
    </div>
    <div class="col-sm-8 col-9 text-right m-b-20">
        <a href="{{ route('roles.create') }}" class="btn btn-primary float-right btn-rounded"><i class="fa fa-plus"></i> Tambah Role</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table">
                <thead>
                    <tr>
                        <th>Nama Role</th>
                        <th>Jumlah User</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>
                                <h2>{{ $role->name }}</h2>
                            </td>
                            <td>
                                {{ $role->users()->count() }}
                            </td>
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('roles.edit', $role->id) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <form method="POST" action="{{ route('roles.destroy', $role->id) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus role ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"><i class="fa fa-trash-o m-r-5"></i> Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Belum ada role.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{ $roles->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection

