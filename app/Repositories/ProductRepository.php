<?php

namespace App\Repositories;

use App\Eloquent\ProductFilter;
use App\Models\Product;
use App\Traits\ModelRepository;
use App\Traits\UtilizesQueryString;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository
{

    use ModelRepository;
    use UtilizesQueryString;

    protected string $defaultSortingColumn = 'name';

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    /**
     * Returns paginated results matching search and filters.
     *
     * @return LengthAwarePaginator
     */
    public function search(): LengthAwarePaginator
    {
        $this->setupValues(request());
        return $this
            ->getBaseQuery()
            ->orderBy($this->sortBy, $this->getSortingDirection())
            ->search($this->term)
            ->filter(new ProductFilter($this->filters))
            ->paginate();
    }

    /**
     * Determines sorting direction.
     *
     * @return string
     */
    protected function getSortingDirection(): string
    {
        return $this->sortAscending ? 'asc' : 'desc';
    }
}
