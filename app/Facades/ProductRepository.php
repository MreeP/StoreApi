<?php

namespace App\Facades;

use App\Repositories\ProductRepository as Repository;
use Illuminate\Support\Facades\Facade;

class ProductRepository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Repository::class;
    }
}
