<?php

namespace App\Traits;

use App\Eloquent\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter($query, QueryFilter $filters): Builder
    {
        return $filters->applyFilters($query);
    }
}
