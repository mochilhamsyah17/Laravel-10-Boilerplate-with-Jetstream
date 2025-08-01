<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Topping;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function addToOrder(Request $request, OrderRepository $orderRepo)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'toppings' => 'nullable|array',
            'toppings.*' => 'exists:toppings,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Ambil data order dari session
        $orders = $orderRepo->getOrderDataFromSession() ?? [];

        // Ambil topping detail dari database
        $toppingsData = [];
        if ($request->has('toppings')) {
            $toppingsData = Topping::whereIn('id', $request->toppings)
                ->get(['id', 'name', 'price'])
                ->toArray();
        }

        // Tambahkan data baru ke array order
        $orders[] = [
            'product_id' => $product->id,
            'imageUrl' => $product->imageUrl,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->quantity,
            'toppings' => $toppingsData,
        ];

        // Simpan kembali ke session
        $orderRepo->saveOrderDataToSession($orders);

        return redirect()->route('dashboard.index')
            ->with('success', 'Produk ditambahkan ke pesanan!');
    }

    public function updateQty(Request $request, OrderRepository $orderRepo)
    {
        $request->validate([
            'key' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        // Ambil order dari session
        $orders = $orderRepo->getOrderDataFromSession();

        if (!isset($orders[$request->key])) {
            return response()->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
        }

        // Update qty
        $orders[$request->key]['quantity'] = $request->quantity;

        // Simpan kembali ke session
        $orderRepo->saveOrderDataToSession($orders);

        // Hitung ulang total item
        $product = $orders[$request->key];
        $toppingTotal = collect($product['toppings'] ?? [])->sum(fn($t) => $t['price'] ?? 0);
        $itemTotal = ($product['price'] + $toppingTotal) * $request->quantity;

        return response()->json([
            'success' => true,
            'quantity' => $request->quantity,
            'item_total' => $itemTotal,
        ]);
    }
}
