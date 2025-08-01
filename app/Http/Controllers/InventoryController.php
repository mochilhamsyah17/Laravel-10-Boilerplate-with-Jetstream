<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Topping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role != 1) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $products = Product::with('toppings')->get();

        return view('admin.inventory.index', compact('products'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->role != 1) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $toppings = Topping::all();
        return view('admin.inventory.create', compact('toppings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products',
            'imageUrl' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:makanan,softdrink,snack,kopi',
            'description' => 'nullable|string|max:255',
            'is_available' => 'required|boolean',
        ]);

        try {
            $imagePath = null;

            if ($request->hasFile('imageUrl')) {
                $image = $request->file('imageUrl');
                $imagePath = $image->store('products', 'public');
            }

            Product::create([
                'name' => $request->name,
                'imageUrl' => $imagePath,
                'price' => $request->price,
                'category' => $request->category,
                'description' => $request->description,
                'is_available' => $request->is_available,
            ]);

            return redirect()->route('inventory.index')->with('success', 'Product created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to create product. ' . $th->getMessage());
        }
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.inventory.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $toppings = Topping::all();
        return view('admin.inventory.edit', compact('product', 'toppings'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'imageUrl' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:makanan,softdrink,snack,kopi',
            'description' => 'nullable|string|max:255',
            'is_available' => 'required|boolean',
            'topping_ids' => 'nullable|array',
            'topping_ids.*' => 'exists:toppings,id',
        ]);


        try {

            if ($request->hasFile('imageUrl')) {
                $image = $request->file('imageUrl');
                $imagePath = $image->store('products', 'public');
                $product->imageUrl = $imagePath;
            }
            $product->name = $request->name;
            $product->price = $request->price;
            $product->category = $request->category;
            $product->description = $request->description;
            $product->is_available = $request->is_available;
            $product->save();

            if ($request->has('topping_ids')) {
                $product->toppings()->sync($request->topping_ids);
            } else {
                $product->toppings()->sync([]);
            }

            return redirect()->route('inventory.index')->with('success', 'Product updated successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'Failed to update product.' . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();

        if ($user->role != 1) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
