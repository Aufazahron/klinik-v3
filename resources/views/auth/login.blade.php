@extends('layouts.preclinic-auth')

@section('content')
<form method="POST" action="{{ route('login') }}" class="form-signin">
    @csrf
    <div class="account-logo">
        <a href="{{ route('login') }}"><img src="{{ asset('preclinic/assets/img/logo-dark.png') }}" alt=""></a>
    </div>
    
    @if (session('status'))
        <div class="alert alert-success mb-3">
            {{ session('status') }}
        </div>
    @endif

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="form-group">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember"> Remember me
            </label>
        </div>
    </div>
    
    <div class="form-group text-right">
        <a href="{{ route('password.request') }}">Forgot your password?</a>
    </div>
    
    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary account-btn">Login</button>
    </div>
    
    <div class="text-center register-link">
        Don't have an account? <a href="{{ route('register') }}">Register Now</a>
    </div>
</form>
@endsection
