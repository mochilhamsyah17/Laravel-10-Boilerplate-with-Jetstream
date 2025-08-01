<?php

namespace App\Http\Controllers;

use App\Models\Topping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToppingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role != 1) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $toppings = Topping::all();
        return view('admin.topping.index', compact('toppings'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->role != 1) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        return view('admin.topping.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:toppings',
            'price' => 'required|numeric|min:0',
            'is_available' => 'required|boolean',
        ]);

        $user = Auth::user();

        if ($user->role != 1) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        try {
            Topping::create($request->all());
            return redirect()->route('topping.index')->with('success', 'Topping created successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'Failed to create topping.' . $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:toppings,name,' . $id,
            'price' => 'required|numeric|min:0',
            'is_available' => 'required|boolean',
        ]);

        $user = Auth::user();

        if ($user->role != 1) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        try {
            $topping = Topping::findOrFail($id);
            $topping->update($request->all());
            return redirect()->route('topping.index')->with('success', 'Topping updated successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'Failed to update topping.' . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();

        if ($user->role != 1) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        try {
            $topping = Topping::findOrFail($id);
            $topping->delete();
            return redirect()->route('topping.index')->with('success', 'Topping deleted successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'Failed to delete topping.' . $th->getMessage());
        }
    }
}
