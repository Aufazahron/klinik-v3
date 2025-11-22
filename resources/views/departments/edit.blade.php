@extends('layouts.preclinic-app')
@section('content')
    <div class="page-header"><h3 class="page-title">Edit Poli</h3></div>
    <div class="card"><div class="card-body">
        <form action="{{ route('departments.update', $department) }}" method="POST">
            @method('PUT')
            @include('departments._form')
        </form>
    </div></div>
@endsection

