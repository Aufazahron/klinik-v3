@extends('layouts.preclinic-app')
@section('content')
    <div class="page-header"><h3 class="page-title">Tambah Poli</h3></div>
    <div class="card"><div class="card-body">
        <form action="{{ route('departments.store') }}" method="POST">
            @include('departments._form', ['department' => null])
        </form>
    </div></div>
@endsection

