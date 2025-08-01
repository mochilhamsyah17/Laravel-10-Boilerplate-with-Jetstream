<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 1) {
            $users = User::get();
            return view('admin.user.index', compact('users'));
        } else {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:1,2,3',
        ]);

        $user = Auth::user();

        if ($user->role != 1) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'Failed to create user.' . $th->getMessage());
        }

        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }
}
