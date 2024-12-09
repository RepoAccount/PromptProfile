@extends('layouts.app')

@section('header_title', 'PromptProfile')
@section('content')
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PromptProfile</title>
</head>
<body>
<section class="hero">
    <div class="hero-content">
        <h2>Welcome to PromptProfile, an Instruction-Based Character Manager</h2>
        <p>This website will help you organize your characters, worlds, and stories for personal and LLM-assisted writing.</p>
        @guest
            <a href="{{ route('login') }}" class="general-button">Login</a>
            <a href="{{ route('register') }}" class="general-button">Register</a>
        @else
            <a href="{{ route('characters.index') }}" class="general-button">Get Started</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="general-button">Log Out</button>
            </form>
        @endguest
    </div>
</section>
</body>
@endsection
