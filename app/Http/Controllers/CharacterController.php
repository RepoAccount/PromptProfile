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
        $characters = auth()->user()->characters()->with('images')->get();
        return view('characters.index', compact('characters'));
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
        ]);

        $character = auth()->user()->characters()->create($validatedData);
        return response()->json(['success' => true, 'id' => $character->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Character $character)
    {
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }

        $character->load(['images', 'segments']);
        $summary = $character->segments->where('segment_type', 'summary')->first()?->content ?? '';

        return view('characters.show', compact('character', 'summary'));
    }

    public function gallery(Character $character)
    {
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }

        return view('characters.gallery.index', compact('character'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Character $character)
    {
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }
        $worlds = World::where('user_id', auth()->id())->get();
        return view('characters.edit', compact('character', 'worlds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Character $character)
    {
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'summary' => 'nullable'
        ]);

        $character->name = $validatedData['name'];
        $character->save();

        if ($validatedData['summary']) {
            $character->segments()->updateOrCreate(
                ['segment_type' => 'summary'],
                ['content' => $validatedData['summary']]
            );
        }

        return response()->json([
            'name' => $character->name,
            'summary' => $validatedData['summary'] ?? ''
        ]);
    }


    public function getWorlds(Character $character)
    {
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }

        $current = $character->worlds;
        $available = World::where('user_id', auth()->id())
            ->whereNotIn('id', $character->worlds->pluck('id'))
            ->get();

        return response()->json([
            'current' => $current,
            'available' => $available
        ]);
    }

    public function list()
    {
        $characters = auth()->user()->characters()
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

    public function addWorld(Character $character, World $world)
    {
        if ($character->user_id !== auth()->id() || $world->user_id !== auth()->id()) {
            abort(403);
        }

        $character->worlds()->attach($world->id);
        return response()->json(['success' => true]);
    }

    public function removeWorld(Character $character, World $world)
    {
        if ($character->user_id !== auth()->id() || $world->user_id !== auth()->id()) {
            abort(403);
        }

        $character->worlds()->detach($world->id);
        return response()->json(['success' => true]);
    }

    public function prompts(Character $character)
    {
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }

        return view('characters.prompts', compact('character'));
    }

    public function updatePrompts(Request $request, Character $character)
    {
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }

        $character->update([
            'main_prompt' => $request->main_prompt,
            'writing_prompt' => $request->writing_prompt,
            'misc_prompt' => $request->misc_prompt
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Character $character)
    {
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }
        $character->delete();
        return response()->json(null, 204);
    }
}
