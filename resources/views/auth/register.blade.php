@extends('layouts.app')

@section('header_title', 'Register')
@section('content')
    <div class="register-container">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <!-- Name field -->
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email field -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password fields -->
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password">
                @error('password')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm">Confirm Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Log In</a>
            </div>

            <button type="submit" class="general-button">Register</button>
        </form>
    </div>
@endsection
