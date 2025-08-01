<?php

namespace App\Http\Controllers;

use App\Repositories\GuestRepository;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function addToGuest(Request $request, GuestRepository $guestRepository)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'table_number' => 'required|integer|min:1',
        ]);

        $guest = [
            'name' => $request->name,
            'table_number' => $request->table_number
        ];

        $guestRepository->saveGuestDataToSession($guest);

        return redirect()->route('dashboard.index')->with('success', 'Nama dan nomor meja berhasil disimpan.');
    }
}
