<?php

namespace App\Interfaces;

interface GuestInterfaces
{
    public function getGuestDataFromSession();

    public function saveGuestDataToSession($data);
}
