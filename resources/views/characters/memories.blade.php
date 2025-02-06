@extends('layouts.app')

@section('header_title', $character->name . ' - Memories')
@section('content')
    <main class="segments-page">
        <div class="segments-grid single-column">
            <div class="segment-column">
                <div class="memory-list">
                    @foreach($memories->sortBy('order') as $memory)
                        <div class="memory" data-id="{{ $memory->id }}">
                            <input type="text" class="segment-title" value="{{ $memory->title }}">
                            <input type="text" class="memory-context" value="{{ $memory->context }}">
                            <textarea class="segment-content">{{ $memory->excerpt }}</textarea>
                            <div class="segment-controls">
                                <input type="text" class="scene-trigger" placeholder="Scene triggers" value="{{ $memory->scene_trigger }}">
                                <input type="number" class="order" value="{{ $memory->order }}">
                                <button class="delete-btn">×</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="add-memory general-button dark-button">Add Memory</button>
            </div>
        </div>
    </main>
    <script>
        const characterId = {{ $character->id }};
    </script>

    @vite('resources/js/memories.ts')
@endsection
