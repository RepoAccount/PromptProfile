@extends('layouts.app')

@section('header_title', $character->name . ' - Information')
@section('content')
    <main class="segments-page">
        <div class="segments-grid">
            <div class="segment-column">
                <h3>Backstory</h3>
                <div class="segment-list" data-type="backstory">
                    @foreach($backstory->sortBy('order') as $segment)
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
                <button id="addBackstory" class="add-segment general-button dark-button" data-type="backstory">Add Entry</button>
            </div>

            <div class="segment-column">
                <h3>Relationships</h3>
                <div class="segment-list" data-type="relationships">
                    @foreach($relationships->sortBy('order') as $segment)
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
                <button id="addRelationships" class="add-segment general-button dark-button" data-type="relationships">Add Entry</button>
            </div>

            <div class="segment-column">
                <h3>Personality</h3>
                <div class="segment-list" data-type="personality">
                @foreach($personality->sortBy('order') as $segment)
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
                <button id="addPersonality" class="add-segment general-button dark-button" data-type="personality">Add Entry</button>
            </div>
        </div>
    </main>

    <script>
        const characterId = {{ $character->id }};
    </script>

    @vite('resources/js/segments.ts')

@endsection
