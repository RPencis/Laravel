<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait AllowedFilterSort
{
    public function parseSortDirection($column = null)
    {
        return strpos($column ?? request()->query('sort_by'),"-") === 0 ? 'desc' : 'asc';
    }

    public function parseSortColumn($column = null)
    {
        return ltrim($column ?? request()->query('sort_by'),"-");
    }

    public function scopeAllowedSorts(Builder $builder, array $columns, $defaultColumn = null)
    {
        $column = $this->parseSortColumn();
        if(in_array($column, $columns)){
            return $builder->orderBy($column, $this->parseSortDirection());
        }
        if(!$column && $defaultColumn){
            return $builder->orderBy($this->parseSortColumn($defaultColumn), $this->parseSortDirection($defaultColumn));
        }
        return $builder;
    }
}
