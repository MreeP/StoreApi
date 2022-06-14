<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait UtilizesQueryString
{

    protected string $term = '';
    protected string $sortBy = '';
    protected bool $sortAscending = true;
    protected array $filters = [];
    protected array $nonFiltersQueryStringKeys = ['page', 'term', 'sortby', 'asc'];

    /**
     * Sets values from query string.
     *
     * @param Request $request
     */
    protected function setupValues(Request $request)
    {
        $this->getSortingParameters($request);
        $this->getSearchTerm($request);
        $this->getFilters($request);
    }

    /**
     * @param Request $request
     */
    protected function getSortingParameters(Request $request)
    {
        if ($request->has('sortby')) {
            $this->sortBy = in_array(
                $request->get('sortby', $this->defaultSortingColumn),
                $this->model->allowedSortingFields()
            )
                ? $request->get('sortby', $this->defaultSortingColumn)
                : $this->defaultSortingColumn;
        } else {
            $this->sortBy = $this->defaultSortingColumn;
        }

        if (!$request->get('asc', true)) {
            $this->sortAscending = false;
        }
    }

    /**
     * @param Request $request
     */
    public function getSearchTerm(Request $request)
    {
        $this->term = $request->get('search', '');
    }

    /**
     * @param Request $request
     */
    public function getFilters(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            if (!in_array($key, $this->nonFiltersQueryStringKeys)) {
                $this->filters[$key] = $value;
            }
        }
    }
}
