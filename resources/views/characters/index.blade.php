@extends('layouts.app')

@section('header_title', 'Character List')
@section('content')
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/ico">
    <title>Character List</title>
</head>
<body>
<main>
    <aside class="sidebar left-sidebar">
        <a href="{{ route('home') }}" class="general-button" id="back-button">Go Back</a>
    </aside>

    <div class="characters-container">
        <div class="character">
            <!-- <a href="profile.html"> -->
                <img src="{{ asset('img/placeholder.jpg') }}" alt="Character 1">
                <p>Character 1</p>
            <!-- </a> -->
        </div>
        <div class="character">
            <!-- <a href="profile.html"> -->
                <img src="{{ asset('img/placeholder2.jpg') }}" alt="Character 2">
                <p>Character 2</p>
            <!-- </a> -->
        </div>
        <div class="character">
            <!-- <a href="profile.html"> -->
                <img src="{{ asset('img/placeholder.jpg') }}" alt="Character 3">
                <p>Character 3</p>
            <!-- </a> -->
        </div>
        <div class="character">
            <!-- <a href="profile.html"> -->
                <img src="{{ asset('img/placeholder2.jpg') }}" alt="Character 4">
                <p>Character 4</p>
            <!-- </a> -->
        </div>
        <div class="character">
            <!-- <a href="profile.html"> -->
                <img src="{{ asset('img/placeholder.jpg') }}" alt="Character 5">
                <p>Character 5</p>
            <!-- </a> -->
        </div>
        <div class="character">
            <!-- <a href="profile.html"> -->
                <img src="{{ asset('img/placeholder2.jpg') }}" alt="Character 6">
                <p>Character 6</p>
            <!-- </a> -->
        </div>
        <div class="character">
            <!-- <a href="profile.html"> -->
                <img src="{{ asset('img/placeholder.jpg') }}" alt="Character 7">
                <p>Character 7</p>
            <!-- </a> -->
        </div>
        <div class="character">
            <!-- <a href="profile.html"> -->
                <img src="{{ asset('img/placeholder2.jpg') }}" alt="Character 8">
                <p>Character 8</p>
            <!-- </a> -->
        </div>
        <div class="character">
            <!-- <a href="profile.html"> -->
                <img src="{{ asset('img/placeholder.jpg') }}" alt="Character 9">
                <p>Character 9</p>
            <!-- </a> -->
        </div>
    </div>

    <aside class="sidebar right-sidebar">
        <div class="filter-section">
            <p>Select World</p>
            <div class="filter-option">World 1</div>
            <div class="filter-option">World 2</div>
            <div class="filter-option">World 3</div>
        </div>
    </aside>

</main>
</body>
</html>
@endsection
