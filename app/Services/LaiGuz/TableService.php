<?php

namespace App\Services\LaiGuz;

use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class TableService
{
    use WithPagination;
    protected $model;
    protected $modelId;
    protected $relationTables;
    protected $columnsInclude;
    protected $searchable;
    protected $sort;
    protected $where;
    protected $paginate;
    protected $search;
    protected $customSearch;
    protected $active;
    protected $filterYear;

    public function __construct()
    {
        // Inicializar variáveis padrão aqui, se necessário.
    }

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    public function setParameters(array $params)
    {
        $this->modelId          = $params['modelId'];
        $this->relationTables   = $params['relationTables'];
        $this->columnsInclude   = $params['columnsInclude'];
        $this->searchable       = $params['searchable'];
        $this->sort             = $params['sort'];
        $this->where            = $params['where'] ?? [];
        $this->paginate         = $params['paginate'];
        $this->search           = $params['search'];
        $this->customSearch     = $params['customSearch'];
        $this->active           = $params['active'];
        $this->filterYear       = $params['filterYear'] ?? [];
        return $this;
    }

    public function getData()
    {
        $query = $this->model::query();

        if ($this->filterYear) {
            $query->whereYear('date', $this->filterYear);
        }

        if (in_array('admin', Auth::user()->jsonGroups) or in_array('super_admin', Auth::user()->jsonGroups)) {
            if (Auth::user()->see_excluded) {
                $query->where($this->active, '<=', 1);
            } else {
                $query->where($this->active,  1);
            }
        } else {
            $query->where($this->active,  1);
        }
        if ($this->where) {
            foreach ($this->where as $key => $value) {
                $query->where($key,  $value);
            }
        }

        if ($this->relationTables) {
            $query = $this->applyRelationTables($query);
        }

        if ($this->columnsInclude) {
            $selects = array_merge([$this->modelId . ' as id'], explode(',', $this->columnsInclude));
        } else {
            $selects = ['*'];
        }
        $query->select($selects);

        if ($this->sort) {
            $query = $this->applySort($query);
        }

        if ($this->search && $this->searchable) {
            $query = $this->applySearch($query);
        }

        return $this->paginate ? $query->paginate($this->paginate) : $query->get();
    }

    protected function applySort(Builder $query): Builder
    {
        foreach ($this->sort as $key => $value) {
            $query->orderBy($key, $value);
        }
        return $query;
    }

    protected function applySearch(Builder $query): Builder
    {
        $searchTerms = explode(',', $this->searchable);
        $query->where(function ($innerQuery) use ($searchTerms) {
            foreach ($searchTerms as $term) {
                if ($this->customSearch) {
                    if (isset($this->customSearch[$term])) {
                        $search = array($this->customSearch[$term] => $this->search);
                        $formattedSearch = $this->model::filterFields($search);
                        if ($formattedSearch) {
                            if ($formattedSearch['converted'] != '%0%') {
                                $innerQuery->orWhere($term, $formattedSearch['f'], $formattedSearch['converted']);
                            } else {
                                $innerQuery->orWhere($term, 'LIKE', '%' . $this->search . '%');
                            }
                        }
                    } else {
                        $innerQuery->orWhere($term, 'LIKE', '%' . $this->search . '%');
                    }
                } else {
                    $innerQuery->orWhere($term, 'LIKE', '%' . $this->search . '%');
                }
            }
        });
        return $query;
    }

    protected function applyRelationTables(Builder $query): Builder
    {
        $relationTables = explode('|', str_replace(' ', '', $this->relationTables));
        foreach ($relationTables as $relationTable) {
            [$table, $key, $foreignKey] = explode(',', $relationTable);
            $query->leftJoin($table, $key, '=', $foreignKey);
        }
        return $query;
    }
}
