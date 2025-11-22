@extends('layouts.preclinic-auth')

@section('content')
<form method="POST" action="{{ route('password.store') }}" class="form-signin">
    @csrf
    <div class="account-logo">
        <a href="{{ route('login') }}"><img src="{{ asset('preclinic/assets/img/logo-dark.png') }}" alt=""></a>
    </div>
    
    <input type="hidden" name="token" value="{{ $request->route('token') ?? $token ?? '' }}">
    
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $request->email ?? '') }}" required autofocus>
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
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>
    
    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary account-btn">Reset Password</button>
    </div>
    
    <div class="text-center register-link">
        <a href="{{ route('login') }}">Back to Login</a>
    </div>
</form>
@endsection
