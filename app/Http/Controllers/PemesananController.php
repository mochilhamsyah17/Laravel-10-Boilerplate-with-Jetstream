<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!in_array($user->role, [1, 2])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $data = Orders::all();

        $dataPending = Orders::where('status', 'pending')->get();
        $dataCompleted = Orders::where('status', 'completed')->get();

        $dataCompletedCount = $dataCompleted->count();
        $dataPendingCount = $dataPending->count();

        // hitung jumlah total_price dari semua data
        $totalPrice = 0;
        foreach ($data as $order) {
            $totalPrice += $order->total_price;
        }

        dd($totalPrice);

        return view('admin.pemesanan.index', compact('data', 'dataCompletedCount', 'dataPendingCount'));
    }
}
