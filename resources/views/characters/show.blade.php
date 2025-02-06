@extends('layouts.app')

@section('header_title', $character->name)
@section('content')
    <main>
        <aside class="sidebar left-sidebar">
            <a href="{{ route('characters.index') }}" class="general-button dark-button">Back</a>
            <button class="general-button dark-button" id="editWorldsBtn">Edit Worlds</button>
            <hr class="sidebar-divider">
            <a href="{{ route('characters.segments', $character->id) }}" class="general-button dark-button">Information</a>
            <a href="{{ route('characters.memories', $character->id) }}" class="general-button dark-button">Memories</a>
            <a href="{{ route('characters.misc', $character->id) }}" class="general-button dark-button">Misc</a>
            <a href="{{ route('characters.prompts', $character->id) }}" class="general-button dark-button">Prompts</a>
            <hr class="sidebar-divider">
            <button class="general-button dark-button" id="deleteCharacter">Delete</button>
        </aside>

        <div class="character-content">
            <div class="profile-header">
                <img class="profile-image" src="{{ $character->profile_image_id ? asset($character->profile_image->file_path) : asset('img/placeholder.jpg') }}" alt="{{ $character->name }}">
                <h2 id="characterName">{{ $character->name }}</h2>
                <textarea id="summary" readonly>{{ $summary }}</textarea>
                <button class="general-button dark-button" id="editBasicInfo">Edit</button>
            </div>
        </div>

        <aside class="sidebar right-sidebar gallery-sidebar">
            <div class="gallery-preview">
                @foreach($character->images->take(6) as $image)
                    <div class="preview-card">
                        <img src="{{ asset($image->file_path) }}" alt="">
                    </div>
                @endforeach
            </div>
            <a href="{{ route('characters.gallery', $character->id) }}" class="general-button dark-button">Gallery</a>
        </aside>

    </main>

    <div id="worldsModal" class="modal">
        <div class="modal-content">
            <span class="close">×</span>
            <h2>Edit Character Worlds</h2>
            <div class="current-worlds">
                <h3>Current Worlds</h3>
                <div id="characterWorlds"></div>
            </div>
            <div class="available-worlds">
                <h3>Available Worlds</h3>
                <div id="worldPicker"></div>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close">×</span>
            <h2>Delete Character</h2>
            <p class="confirmation">Are you sure you want to delete {{ $character->name }} and all its data?</p>
            <div class="modal-buttons">
                <button class="general-button" id="confirmDelete">Delete</button>
                <button class="general-button close-modal">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        const characterId = {{ $character->id }};
    </script>

    @vite('resources/js/basicInfo.ts')
    @vite('resources/js/worldManager.ts')
    @vite('resources/js/characterDeletion.ts')
@endsection
