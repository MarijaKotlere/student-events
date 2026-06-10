<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function index()
    {
        $users = User::whereNot('role', 'admin')-> get();

        return view('users.index', compact('users'));
    }

    public function block(User $user)
    {
        $user->update([
            'blocked' => true,
        ]);

        return back()->with('success', 'User has been blocked.');
    }

    public function unblock(User $user) 
    {
        $user->update([
            'blocked' => false,
        ]);

        return back()->with('success', 'User has been unblocked.');
    }

    public function edit()
    {   
        $user = auth()->user();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
     
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.auth()->id(),
            'password' => 'confirmed',
        ]);

        $user->email = $validated['email'];
        $user->name = $validated['name'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('events.index')
            ->with('success', 'User updated successfully.');
    }
}