<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CharacterSegmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'character_id' => 'required|exists:characters,id',
            'segment_type' => 'required|string',
            'title' => 'required|string',
            'content' => 'required|string',
            'scene_trigger' => 'nullable|string',
            'order' => 'required|integer',
        ]);

        $segment = CharacterSegment::create($validatedData);
        return response()->json($segment, 201);
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
    public function update(Request $request, CharacterSegment $characterSegment)
    {
        $validatedData = $request->validate([
            'segment_type' => 'required|string',
            'title' => 'required|string',
            'content' => 'required|string',
            'scene_trigger' => 'nullable|string',
            'order' => 'required|integer',
        ]);

        $characterSegment->update($validatedData);
        return response()->json($characterSegment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CharacterSegment $characterSegment)
    {
        $characterSegment->delete();
        return response()->json(null, 204);
    }
}
