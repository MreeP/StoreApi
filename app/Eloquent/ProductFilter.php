<?php

namespace App\Eloquent;

class ProductFilter extends QueryFilter
{

    public function onSaleFilter($value)
    {
        $this->builder->where('products.sale', $value ? true : false);
    }
}
