<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\OrderItemTopping;
use App\Models\Orders;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index($id)
    {
        $product = Product::find($id);
        $order = session('order');

        return view('pages.product.index', compact('product', 'order'));
    }
    public function checkout()
    {
        $orderItems = session('order');
        if (empty($orderItems)) {
            return redirect()->route('dashboard.index')->with('error', 'Tidak ada pesanan!');
        }

        // hanya ambil item yang index-nya numeric (produk)
        $products = array_filter($orderItems, function ($key) {
            return is_numeric($key);
        }, ARRAY_FILTER_USE_KEY);


        // pastikan topping di-decode kalau ada yang berbentuk string JSON
        foreach ($products as &$item) {
            if (isset($item['toppings']) && is_string($item['toppings'])) {
                $item['toppings'] = json_decode($item['toppings'], true);
            }
        }
        return view('pages.product.checkout', [
            'orderItems' => $products
        ]);
    }

    public function removeItem(Request $request)
    {
        $key = $request->key;

        // Ambil isi session 'order'
        $order = session('order', []);

        // Cek apakah key-nya ada
        if (isset($order[$key])) {
            unset($order[$key]); // Hapus berdasarkan index array

            // Reset ulang session-nya
            session(['order' => array_values($order)]); // Reindex supaya key-nya rapih

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function storeOrder(Request $request)
    {
        $order = session('order');
        $guest = session('guest');

        if (empty($order) || empty($guest)) {
            return redirect()->route('products.index')->with('error', 'Data pesanan tidak ditemukan');
        }

        DB::beginTransaction();
        try {
            // Buat order baru di database
            $newOrder = Orders::create([
                'name' => $order['name'],
                'table_number' => $order['table_number'],
                'status' => $order['status'],
                'total_price' => $order['total_price']
            ]);

            // Loop items dan simpan ke database
            foreach ($order['items'] as $item) {
                // Handle toppings - bisa berupa array langsung dari form atau JSON string
                $toppings = $item['toppings'] ?? [];

                // Jika toppings masih JSON string, decode dulu
                if (is_string($toppings)) {
                    $toppings = json_decode($toppings, true);
                    if (!is_array($toppings)) {
                        $toppings = [];
                    }
                }

                // Hitung subtotal produk dasar
                $productSubtotal = $item['quantity'] * $item['price'];

                // Hitung total harga toppings per item
                $toppingsTotal = 0;
                if (!empty($toppings)) {
                    foreach ($toppings as $topping) {
                        $toppingsTotal += floatval($topping['price'] ?? 0);
                    }
                }

                // Total toppings dikalikan dengan quantity
                $toppingsSubtotal = $toppingsTotal * $item['quantity'];

                // Subtotal keseluruhan = (harga produk + harga toppings) * quantity
                $itemSubtotal = $productSubtotal + $toppingsSubtotal;

                // Simpan order item
                $orderItem = OrderItem::create([
                    'order_id' => $newOrder->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'notes' => $item['note'] ?? null,
                    'price' => $itemSubtotal,
                ]);

                // Simpan toppings ke tabel order_item_toppings
                if (!empty($toppings)) {
                    foreach ($toppings as $topping) {
                        OrderItemTopping::create([
                            'order_item_id' => $orderItem->id,
                            'topping_id' => $topping['id'],
                            'quantity' => $item['quantity'],
                            'price' => floatval($topping['price'] ?? 0)
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('products.wait')->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }
    public function confirm()
    {
        $order = session('order');
        $guest = session('guest');

        // Validasi jika data tidak ada
        if (empty($order) || empty($guest)) {
            return redirect()->route('products.index')->with('error', 'Data pesanan tidak ditemukan');
        }

        // Pastikan data order memiliki struktur yang benar
        if (!isset($order['items']) || !is_array($order['items'])) {
            return redirect()->route('dashboard.index')->with('error', 'Data pesanan tidak valid');
        }

        return view('pages.product.confirm', compact('guest', 'order'));
    }

    public function store(Request $request)
    {
        $guest = session('guest');

        if (empty($guest)) {
            return view('welcome');
        }

        try {
            $guest = session('guest');

            // Parse order_items jika berupa JSON string
            $orderItems = $request->order_items;
            if (is_string($orderItems)) {
                $orderItems = json_decode($orderItems, true);
            }

            // Validasi bahwa orderItems adalah array
            if (!is_array($orderItems)) {
                throw new \Exception('Format order_items tidak valid');
            }

            $total = 0;

            // Hitung total untuk preview
            foreach ($orderItems as $item) {
                // Handle toppings - bisa berupa array langsung dari form atau JSON string
                $toppings = $item['toppings'] ?? [];

                // Jika toppings masih JSON string, decode dulu
                if (is_string($toppings)) {
                    $toppings = json_decode($toppings, true);
                    if (!is_array($toppings)) {
                        $toppings = [];
                    }
                }

                // Hitung subtotal produk dasar
                $productSubtotal = $item['quantity'] * $item['price'];

                // Hitung total harga toppings per item
                $toppingsTotal = 0;
                if (!empty($toppings)) {
                    foreach ($toppings as $topping) {
                        $toppingsTotal += floatval($topping['price'] ?? 0);
                    }
                }

                // Total toppings dikalikan dengan quantity
                $toppingsSubtotal = $toppingsTotal * $item['quantity'];

                // Subtotal keseluruhan = (harga produk + harga toppings) * quantity
                $itemSubtotal = $productSubtotal + $toppingsSubtotal;

                $total += $itemSubtotal;
            }

            // Simpan data order ke session untuk konfirmasi
            $orderData = [
                'name' => $guest['name'],
                'table_number' => $guest['table_number'],
                'status' => 'pending',
                'total_price' => $total,
                'items' => $orderItems
            ];

            session(['order' => $orderData]);

            return redirect()->route('products.confirm');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    public function wait()
    {
        $guest = session('guest');
        $order = session('order');

        // Validasi session data
        if (empty($guest)) {
            return redirect()->route('products.index')->with('error', 'Data tamu tidak ditemukan');
        }

        // Cari order terbaru berdasarkan nama dan nomor meja
        $orderData = Orders::where('name', $guest['name'])
            ->where('table_number', $guest['table_number'])
            ->orderBy('created_at', 'desc')
            ->first();

        if (empty($orderData)) {
            return redirect()->route('products.index')->with('error', 'Data pesanan tidak ditemukan');
        }

        // Ambil order items dengan relasi
        $orderItems = OrderItem::with(['product', 'toppings'])
            ->where('order_id', $orderData->id)
            ->get();

        if ($orderItems->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Item pesanan tidak ditemukan');
        }

        return view('pages.product.wait', compact('orderData', 'orderItems', 'guest'));
    }
}
