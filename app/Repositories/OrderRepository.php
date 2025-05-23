<?php

namespace App\Repositories;

use App\Interfaces\OrderInterfaces;

class OrderRepository implements OrderInterfaces
{
    public function getOrderDataFromSession()
    {
        return session()->get('order');
    }

    public function saveOrderDataToSession($data)
    {
        session()->put('order', $data);
    }
}
