<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait AllowedFilterSearch
{
    public function scopeAllowedSearch(Builder $builder, ...$keys)
    {
        if ($search = request()->query('search')) {
            foreach ($keys as $index => $key) {
                $method = $index === 0 ? 'where' : 'orWhere';
                $builder->{$method}($key, "LIKE", "%{$search}%");
            }
        }
        return $builder;
    }

    public function scopeAllowedTrash(Builder $builder)
    {
        if (request()->query('trash')) {
            $builder->onlyTrashed();
        }
        return $builder;
    }
}
