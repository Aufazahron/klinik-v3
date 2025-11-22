@extends('layouts.preclinic-app')

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Edit Asuransi</h3>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('insurances.update', $insurance) }}" method="POST">
            @method('PUT')
            @include('insurances._form')
        </form>
    </div>
</div>
@endsection

