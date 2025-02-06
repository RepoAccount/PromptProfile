<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

    public function store(Request $request, Character $character)
    {
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'images.*' => 'required|image'
        ]);

        $images = [];
        foreach ($request->file('images') as $file) {
            $path = $file->store('character-images', 'public');

            $image = $character->images()->create([
                'file_path' => Storage::url($path),
                'type' => $request->input('type', 'profile')
            ]);

            $images[] = $image;
        }

        return response()->json($images);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function setProfile(Character $character, Image $image, Request $request)
    {
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }

        if ($image->character_id !== $character->id) {
            abort(403);
        }

        if ($request->isMethod('delete')) {
            $character->update(['profile_image_id' => null]);
        } else {
            $character->update(['profile_image_id' => $image->id]);
        }

        return response()->json(['success' => true]);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Character $character, Image $image)
    {
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }

        if ($image->character_id !== $character->id) {
            abort(403);
        }

        Storage::disk('public')->delete(str_replace('storage/', '', $image->file_path));
        $image->delete();

        return response()->json(null, 204);
    }
}
