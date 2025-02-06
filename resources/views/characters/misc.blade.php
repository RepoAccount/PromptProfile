@extends('layouts.app')

@section('header_title', $character->name . ' - Misc')
@section('content')
    <main class="segments-page">
        <div class="segments-grid single-column">
            <div class="segment-column">
                <div class="segment-list" data-type="misc">
                    @foreach($segments->sortBy('order') as $segment)
                        <div class="segment" data-id="{{ $segment->id }}">
                            <input type="text" class="segment-title" value="{{ $segment->title }}">
                            <textarea class="segment-content">{{ $segment->content }}</textarea>
                            <div class="segment-controls">
                                <input type="text" class="scene-trigger" placeholder="Scene triggers" value="{{ $segment->scene_trigger }}">
                                <input type="number" class="order" value="{{ $segment->order }}">
                                <button class="delete-btn">×</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button id="addMisc" class="general-button dark-button" data-type="misc">Add Entry</button>
            </div>
        </div>
    </main>
    <script>
        const characterId = {{ $character->id }};
    </script>
    @vite('resources/js/segments.ts')
@endsection
