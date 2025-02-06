@extends('layouts.app')

@section('header_title', $character->name . ' - Prompts')
@section('content')
    <main class="segments-page">

        <div class="segments-grid">
            <div class="segment-column">
                <h3>Main Prompt</h3>
                <textarea id="mainPrompt" class="prompt-text">{{ $character->main_prompt }}</textarea>
            </div>

            <div class="segment-column">
                <h3>Writing Prompt</h3>
                <textarea id="writingPrompt" class="prompt-text">{{ $character->writing_prompt }}</textarea>
            </div>

            <div class="segment-column">
                <h3>Misc Prompt</h3>
                <textarea id="miscPrompt" class="prompt-text">{{ $character->misc_prompt }}</textarea>
            </div>
        </div>
    </main>

<script>
        const characterId = {{ $character->id }};
</script>
@vite('resources/js/prompts.ts')
@endsection
