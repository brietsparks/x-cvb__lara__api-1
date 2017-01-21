<?php

namespace App\Models\Facades;

use Illuminate\Support\Facades\Facade;

class ExpServiceFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'expService';
    }

}