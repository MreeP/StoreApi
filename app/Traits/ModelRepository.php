<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ModelRepository
{
    private function getBaseQuery(): Builder
    {
        return $this->model->newQuery();
    }
}
