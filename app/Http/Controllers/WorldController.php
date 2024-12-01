<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class   WorldController extends Controller
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
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $world = World::create($validatedData);
        return response()->json($world, 201);
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
    public function update(Request $request, World $world)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $world->update($validatedData);
        return response()->json($world);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(World $world)
    {
        $world->delete();
        return response()->json(null, 204);
    }
}
