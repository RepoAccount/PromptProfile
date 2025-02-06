<?php

namespace App\Http\Controllers;

use App\Models\World;
use Illuminate\Http\Request;

class   WorldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $worlds = auth()->user()?->load('worlds')->worlds;
            return response()->json($worlds);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $world = auth()->user()->worlds()->create($validatedData);
        return response()->json($world, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(World $world)
    {
        if ($world->user_id !== auth()->id()) {
            abort(403);
        }
        return response()->json($world);
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
    public function update(Request $request, World $world)
    {
        if ($world->user_id !== auth()->id()) {
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $world->update($validatedData);
        return response()->json($world);
    }

    public function getCharacters(World $world)
    {
        if ($world->user_id !== auth()->id()) {
            abort(403);
        }

        $characters = $world->characters()
            ->with(['images', 'profile_image'])
            ->get()
            ->map(function($character) {
                return [
                    'id' => $character->id,
                    'name' => $character->name,
                    'image' => $character->profile_image ? asset($character->profile_image->file_path) : null
                ];
            });

        return response()->json($characters);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(World $world)
    {
        if ($world->user_id !== auth()->id()) {
            abort(403);
        }

        $world->delete();
        return response()->json(null, 204);
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

}
