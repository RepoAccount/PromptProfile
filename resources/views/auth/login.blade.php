@extends('layouts.app')

@section('header_title', 'Log In')
@section('content')
    <!DOCTYPE html>
    <div class="login-container">
        <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
                @error('password')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Remember Me</label>
            </div>
            <button type="submit" class="general-button">Login</button>
        </form>
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot-password">Forgot Your Password?</a>
        @endif
        <div class="register-link">
            Don't have an account? <a href="{{ route('register') }}">Register</a>
        </div>
    </div>

@endsection
