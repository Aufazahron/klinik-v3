@extends('layouts.preclinic-auth')

@section('content')
<div class="main-wrapper auth-bg position-relative overflow-hidden">

        <div class="container-fuild position-relative z-1">
            <div class="w-100 overflow-hidden position-relative flex-wrap d-block vh-100">

                <div class="row justify-content-center align-items-center vh-100 overflow-auto flex-wrap">
                    <div class="col-lg-4 mx-auto">

                        {{-- PERUBAHAN UTAMA: Form Action diubah ke rute password.email Laravel --}}
                        <form method="POST" action=# class="d-flex justify-content-center align-items-center">
                            @csrf {{-- Tambahkan CSRF Token --}}
                            <div class="d-flex flex-column justify-content-lg-center p-4 p-lg-0 pb-0 flex-fill">
                                <div class=" mx-auto mb-4 text-center">
                                    <img src="{{ asset('assets/clinic/img/logo.svg') }}" class="img-fluid" alt="Logo">
                                </div>
                                <div class="card border-1 p-lg-3 shadow-md rounded-3 mb-4">
                                    <div class="card-body">

                                        {{-- Tambahkan penanganan status sesi (pesan sukses) dari Laravel --}}
                                        @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                        @endif

                                        <div class="text-center mb-3">
                                            <h5 class="mb-1 fs-20 fw-bold">Forgot Password</h5>
                                            <p class="mb-0">No worries, we’ll send you reset instructions</p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="email">Email Address</label>
                                            <div class="input-group">
                                                <span class="input-group-text border-end-0 bg-white">
                                                    <i class="ti ti-mail fs-14 text-dark"></i>
                                                </span>
                                                {{-- Tambahkan atribut name="email" agar Laravel dapat memproses input ini --}}
                                                <input type="email" name="email" id="email" class="form-control border-start-0 ps-0" placeholder="Enter Email Address" required autofocus>
                                            </div>
                                            {{-- Penanganan error untuk field email --}}
                                            @error('email')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <button type="submit" class="btn bg-primary text-white w-100">Reset Password </button>
                                        </div>
                                        <div class="text-center">
                                            <h6 class="fw-normal fs-14 text-dark mb-0">Return to
                                                {{-- PERUBAHAN UTAMA: Tautan Login diubah ke rute Laravel --}}
                                                <a href="{{ route('login') }}" class="hover-a"> login</a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <img src="{{ asset('assets/clinic/img/auth/auth-bg-top.png') }}" alt="" class="img-fluid element-01">
        <img src="{{ asset('assets/clinic/img/auth/auth-bg-bot.png') }}" alt="" class="img-fluid element-02">
    </div>
@endsection
