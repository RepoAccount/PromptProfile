<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\World;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('characters.index'); // placeholder
        // $characters = Character::with('worlds')->get();
        // return view('characters.index', compact('characters')); TODO: UI
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('characters.create'); TODO: UI
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'main_prompt' => 'required',
            'writing_prompt' => 'nullable',
            'misc_prompt' => 'nullable',
        ]);

        $character = auth()->user()->characters()->create($validatedData);
        if ($request->has('worlds')) {
            $character->worlds()->attach($request->worlds);
        }

        return redirect()->route('characters.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Character $character)
    {
        // return view('characters.show', compact('character')); TODO:UI
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Character $character)
    {
        $worlds = World::all();
        return view('characters.edit', compact('character', 'worlds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Character $character)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'main_prompt' => 'required',
            'writing_prompt' => 'nullable',
            'misc_prompt' => 'nullable',
        ]);

        $character->update($validatedData);
        // $character->worlds()->sync($request->worlds); TODO: UI

        // return redirect()->route('characters.show', $character); TODO: UI
        return response()->json($character);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Character $character)
    {
        $character->delete();
        // return redirect()->route('characters.index'); TODO: UI
        return response()->json(null, 204);
    }
}
