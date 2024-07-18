<?php

namespace App\Facades;

use App\Repo\Cart\CartRepo;
use Illuminate\Support\Facades\Facade;

class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CartRepo::class;
    }
}