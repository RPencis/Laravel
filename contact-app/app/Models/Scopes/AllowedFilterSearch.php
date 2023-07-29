<?php

namespace App\Models\Scopes;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait AllowedFilterSearch
{
    public function scopeForUser(Builder $builder, User $user){
        // return $builder->where('user_id',$user->id);
        return $builder->whereBelongsTo($user);
    }
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
