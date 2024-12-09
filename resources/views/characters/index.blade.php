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
    <div id="createModal" class="modal">
        <div class="modal-content">
            <span class="close">×</span>
            <h2>Input character name</h2>
            <input type="text" id="characterName" placeholder="Character Name">
            <p id="validationError"></p>
            <button class="general-button" id="submitCharacter">Create</button>
        </div>
    </div>
    <aside class="sidebar left-sidebar">
        <a href="{{ route('home') }}" class="general-button dark-button">Go Back</a>
        <button id="createCharacterBtn" class="general-button dark-button">Add New</button>
    </aside>
    <div class="characters-container">
        @foreach($characters as $character)
            <div class="character">
                <a href="{{ route('characters.show', $character->id) }}">
                    <img src="{{ $character->images->first() ? asset($character->images->first()->file_path) : asset('img/placeholder.jpg') }}" alt="{{ $character->name }}">
                    <p>{{ $character->name }}</p>
                </a>
            </div>
        @endforeach
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
@vite('resources/js/characterCreation.ts')
</body>
</html>
@endsection
