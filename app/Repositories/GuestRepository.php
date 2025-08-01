<?php

namespace App\Repositories;

use App\Interfaces\GuestInterfaces;

class GuestRepository implements GuestInterfaces
{
    public function getGuestDataFromSession()
    {
        return session()->get('guest');
    }

    public function saveGuestDataToSession($data)
    {
        session()->put('guest', $data);
    }
}
