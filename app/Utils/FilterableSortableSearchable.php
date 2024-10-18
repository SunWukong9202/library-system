<?php

namespace App\Utils;

trait FilterableSortableSearchable
{
    public function scopeFilter($query, array $filters)
    {
        foreach ($filters as $column => $value) {
            if ($value !== null) {
                if (in_array($column, $this->sortable)) {
                    $query->where($column, $value);
                }
            }
        }
        return $query;
    }

    public function scopeSearch($query, $term, $searchables = [])
    {
        if ($term) {
            $query->where(function ($query) use ($term, $searchables) {
                if(empty($searchables)){
                    foreach ($this->searchable as $column) {
                        $query->orWhere($column, 'LIKE', '%' . $term . '%');
                    }
                }
                else 
                {
                    foreach ($searchables as $column) {
                        $query->orWhere($column, 'LIKE', '%' . $term . '%');
                    }
                }
            });
        }
        return $query;
    }

    public function scopeSort($query, $column, $direction = 'asc')
    {
        // Asegurarse de que la columna exista en la tabla para evitar SQL injection
        if (in_array($column, $this->sortable)) {
            return $query->orderBy($column, $direction);
        }
        return $query;
    }
}