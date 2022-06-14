<?php


namespace App\Eloquent;

use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{

    protected Builder $builder;

    protected array $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function applyFilters(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->filters as $func => $param) {
            $func = $func . 'Filter';
            if (method_exists($this, $func) && $param !== null) {
                $this->$func($param);
            }
        }

        return $this->builder;
    }
}
