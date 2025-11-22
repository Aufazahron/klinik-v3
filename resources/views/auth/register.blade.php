@extends('layouts.preclinic-auth')

@section('content')
<form method="POST" action="{{ route('register') }}" class="form-signin">
    @csrf
    <div class="account-logo">
        <a href="{{ route('login') }}"><img src="{{ asset('preclinic/assets/img/logo-dark.png') }}" alt=""></a>
    </div>
    
    <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}" required autofocus>
        @error('full_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <input type="hidden" name="role" value="admin">
    
    <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
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
        <button type="submit" class="btn btn-primary account-btn">Signup</button>
    </div>
    
    <div class="text-center login-link">
        Already have an account? <a href="{{ route('login') }}">Login</a>
    </div>
</form>
@endsection
