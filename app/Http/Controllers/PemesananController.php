<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{

    private function applyFiltersAndSorting($query, $filters)
    {
        // Tetapkan nilai default untuk filter
        $filters = array_merge([
            'search' => null,
            'sort_by' => 'id',  // Default sorting column untuk history
            'order' => 'desc',  // Default order untuk history (terbaru dulu)
            'status_filter' => null,
        ], $filters);

        // Terapkan filter search jika ada
        if ($filters['search']) {
            $query->where(function ($q) use ($filters) {
                $q->where('id', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('table_number', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Terapkan filter status jika ada (hanya status yang ada di history)
        if ($filters['status_filter']) {
            $query->where('status', $filters['status_filter']);
        }

        // Validasi kolom sorting yang diizinkan untuk history
        $validSorting = [
            'id' => 'id',
            'name' => 'name',
            'table_number' => 'table_number',
        ];

        $sort_by = $filters['sort_by'] ?? 'id';
        $order = $filters['order'] ?? 'desc';

        // Terapkan sorting jika kolom valid
        if (array_key_exists($sort_by, $validSorting)) {
            $query->orderBy($validSorting[$sort_by], $order);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        if (!in_array($user->role, [1, 2])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Ambil filter dari query string
        $filters = $request->only(['search', 'sort_by', 'order', 'status_filter']);

        // Mulai query
        $query = Orders::with('orderItems.product', 'orderItems.toppings')
            ->has('orderItems');

        // Terapkan filter dan sorting
        $query = $this->applyFiltersAndSorting($query, $filters);

        // Eksekusi query
        $data = $query->get();

        // Data tambahan
        $dataPending = Orders::where('status', 'pending')->get();
        $dataCompleted = Orders::where('status', 'completed')->get();
        $dataCompletedCount = $dataCompleted->count();
        $dataPendingCount = $dataPending->count();
        $totalPrice = Orders::where('status', 'completed')->sum('total_price');


        return view('admin.pemesanan.index', compact(
            'data',
            'dataCompletedCount',
            'dataPendingCount',
            'totalPrice',
            'filters'
        ));
    }


    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();

        if (!in_array($user->role, [1, 2])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        try {
            $order = Orders::find($id);

            if (!$order) {
                return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
            }

            $order->status = $request->status;
            $order->save();

            return redirect()->route('pemesanan.index')->with('success', 'Status pesanan berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal memperbarui status pesanan. ' . $th->getMessage());
        }
    }

    public function detail($id)
    {
        $user = Auth::user();

        if (!in_array($user->role, [1, 2])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        $order = Orders::with('orderItems.product', 'orderItems.toppings')->find($id);
        return view('admin.pemesanan.detail', compact('order'));
    }
}
