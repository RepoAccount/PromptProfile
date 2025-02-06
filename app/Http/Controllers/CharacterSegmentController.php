<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\CharacterSegment;
use Illuminate\Http\Request;

class CharacterSegmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Character $character)
    {
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }

        $backstory = $character->segments()->where('segment_type', 'backstory')->orderBy('order')->get();
        $relationships = $character->segments()->where('segment_type', 'relationships')->orderBy('order')->get();
        $personality = $character->segments()->where('segment_type', 'personality')->orderBy('order')->get();

        return view('characters.segments', [
            'character' => $character,
            'backstory' => $backstory,
            'relationships' => $relationships,
            'personality' => $personality
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Character $character)
    {
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }

        $segment = $character->segments()->create([
            'segment_type' => $request->type,
            'content' => ''
        ]);

        return response()->json($segment);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Character $character, CharacterSegment $segment)
    {
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }

        $validatedData = $request->validate([
            'order' => 'required|integer|min:0'
        ]);

        $segment->update([
            'title' => $request->title,
            'content' => $request->segment_content ?? '',
            'scene_trigger' => $request->scene_trigger,
            'order' => $validatedData['order']
        ]);

        return response()->json($segment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Character $character, CharacterSegment $segment)
    {
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }

        $segment->delete();
        return response()->json(null, 204);
    }

    public function misc(Character $character)
    {
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }

        $segments = $character->segments()
            ->where('segment_type', 'misc')
            ->orderBy('order')
            ->get();

        return view('characters.misc', [
            'character' => $character,
            'segments' => $segments
        ]);
    }

}
