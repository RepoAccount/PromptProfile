<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\CharacterMemory;
use Illuminate\Http\Request;

class CharacterMemoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Character $character)
    {
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }

        $memories = $character->memories()->orderBy('order')->get();
        return view('characters.memories', compact('character', 'memories'));
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

        $memory = $character->memories()->create([
            'title' => '',
            'context' => '',
            'excerpt' => ''
        ]);

        return response()->json($memory);
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
    public function update(Request $request, Character $character, CharacterMemory $memory)
    {
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }

        $memory->update([
            'title' => $request->title ?? '',
            'context' => $request->context ?? '',
            'excerpt' => $request->excerpt ?? '',
            'scene_trigger' => $request->scene_trigger,
            'order' => $request->order
        ]);

        return response()->json($memory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Character $character, CharacterMemory $memory)
    {
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }

        $memory->delete();
        return response()->json(null, 204);
    }
}
