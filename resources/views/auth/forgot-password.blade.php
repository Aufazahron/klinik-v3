@extends('layouts.preclinic-auth')

@section('content')
<form method="POST" action="{{ route('password.email') }}" class="form-signin">
    @csrf
    <div class="account-logo">
        <a href="{{ route('login') }}"><img src="{{ asset('preclinic/assets/img/logo-dark.png') }}" alt=""></a>
    </div>
    
    <div class="mb-3 text-center">
        <p class="text-muted">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
    </div>
    
    @if (session('status'))
        <div class="alert alert-success mb-3">
            {{ session('status') }}
        </div>
    @endif
    
    <div class="form-group">
        <label>Enter Your Email</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary account-btn">Reset Password</button>
    </div>
    
    <div class="text-center register-link">
        <a href="{{ route('login') }}">Back to Login</a>
    </div>
</form>
@endsection
