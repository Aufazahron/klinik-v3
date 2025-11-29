@extends('layouts.preclinic-auth')

@section('content')
<div class="main-wrapper auth-bg position-relative overflow-hidden">

        <div class="container-fuild position-relative z-1">
            <div class="w-100 overflow-hidden position-relative flex-wrap d-block vh-100">

                <div class="row justify-content-center align-items-center vh-100 overflow-auto flex-wrap py-3">
                    <div class="col-lg-4 mx-auto">

                        {{-- PERUBAHAN UTAMA: Form Action diubah ke rute Laravel --}}
                        <form method="POST" action="{{ route('login') }}" class="d-flex justify-content-center align-items-center">
                            @csrf {{-- Tambahkan CSRF Token untuk keamanan Laravel --}}
                            <div class="d-flex flex-column justify-content-lg-center p-4 p-lg-0 pb-0 flex-fill">
                                <div class=" mx-auto mb-4 text-center">
                                    <img src="{{ asset('assets/clinic/img/logo.svg') }}" class="img-fluid" alt="Logo">
                                </div>
                                <div class="card border-1 p-lg-3 shadow-md rounded-3 mb-4">
                                    <div class="card-body">
                                        <div class="text-center mb-3">
                                            <h5 class="mb-1 fs-20 fw-bold">Sign In</h5>
                                            <p class="mb-0">Please enter below details to access the dashboard</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="email">Email Address</label>
                                            <div class="input-group">
                                                <span class="input-group-text border-end-0 bg-white">
                                                    <i class="ti ti-mail fs-14 text-dark"></i>
                                                </span>
                                                <input type="email" name="email" id="email" class="form-control border-start-0 ps-0" placeholder="Enter Email Address" required autofocus>
                                            </div>
                                            {{-- Anda bisa menambahkan error handling Laravel di sini, contoh: @error('email') <span class="text-danger">{{ $message }}</span> @enderror --}}
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="password">Password</label>
                                            <div class="position-relative">
                                                <div class="pass-group input-group position-relative border rounded">
                                                    <span class="input-group-text bg-white border-0">
                                                        <i class="ti ti-lock text-dark fs-14"></i>
                                                    </span>
                                                    <input type="password" name="password" id="password" class="pass-input form-control ps-0 border-0" placeholder="****************" required>
                                                    <span class="input-group-text bg-white border-0">
                                                        <i class="ti toggle-password ti-eye-off text-dark fs-14"></i>
                                                    </span>
                                                </div>
                                                {{-- Anda bisa menambahkan error handling Laravel di sini, contoh: @error('password') <span class="text-danger">{{ $message }}</span> @enderror --}}
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="form-check form-check-md mb-0">
                                                    <input class="form-check-input" id="remember_me" name="remember" type="checkbox">
                                                    <label for="remember_me" class="form-check-label mt-0 text-dark">Remember Me</label>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                {{-- PERUBAHAN UTAMA: Forgot Password diubah ke rute Laravel --}}
                                                <a href="{{ route('password.request') }}" class="text-danger">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <button type="submit" class="btn bg-primary text-white w-100">Login</button>
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
