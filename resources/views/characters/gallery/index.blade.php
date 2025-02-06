@extends('layouts.app')

@section('header_title', $character->name . ' - Gallery')
@section('content')
    <main>
        <aside class="sidebar left-sidebar">
            <a href="{{ route('characters.show', $character->id) }}" class="general-button dark-button">Back</a>
            <div id="uploadError" class="error-message"></div>
            <button class="general-button dark-button" id="uploadBtn">Add Image</button>
            <input type="file" id="imageInput" multiple accept="image/*" style="display: none">
            <div class="type-select">
                <label>Image Type</label>
                <select id="imageType">
                    <option value="profile">Profile</option>
                    <option value="background">Background</option>
                    <option value="expression">Misc</option>
                </select>
            </div>
        </aside>

        <div class="gallery-content">
            <div class="image-section">
                <h3>Profile Pictures</h3>
                <div class="image-grid profile-grid">
                    @foreach($character->images->where('type', 'profile') as $image)
                        <div class="image-card" data-id="{{ $image->id }}">
                            <img src="{{ asset($image->file_path) }}" alt="">
                            <div class="image-controls">
                                <button class="star-image {{ $character->profile_image_id === $image->id ? 'active' : '' }}">★</button>
                                <button class="delete-image">×</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            <div class="image-section">
            <h3>Backgrounds</h3>
            <div class="image-grid background-grid">
                @foreach($character->images->where('type', 'background') as $image)
                    <div class="image-card" data-id="{{ $image->id }}">
                        <img src="{{ asset($image->file_path) }}" alt="">
                        <div class="image-controls">
                            <button class="delete-image">×</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="image-section">
            <h3>Misc</h3>
            <div class="image-grid misc-grid">
                @foreach($character->images->where('type', 'expression') as $image)
                    <div class="image-card" data-id="{{ $image->id }}">
                        <img src="{{ asset($image->file_path) }}" alt="">
                        <div class="image-controls">
                            <button class="delete-image">×</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        </div>

    </main>
    <script>
        const characterId = {{ $character->id }};
    </script>

    @vite('resources/js/gallery.ts')
@endsection
