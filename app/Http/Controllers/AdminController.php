<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'role' => 'required|in:admin,user'
        ]);

        $user->update(['role' => $validatedData['role']]);
        return response()->json(['success' => true]);
    }
}
