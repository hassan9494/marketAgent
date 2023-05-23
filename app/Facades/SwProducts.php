<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;


class SwProducts extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'SwProducts';
    }
}
