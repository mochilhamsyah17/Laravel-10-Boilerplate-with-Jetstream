<?php

namespace App\Interfaces;

interface OrderInterfaces
{
    public function getOrderDataFromSession();

    public function saveOrderDataToSession($data);
}
