<?php

namespace App\Models;

use App\Models\Scopes\AllowedFilterSearch;
use App\Models\Scopes\AllowedFilterSort;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes, AllowedFilterSearch, AllowedFilterSort;

    protected $fillable = ['first_name', 'last_name', 'phone', 'email', 'address', 'company_id'];

    public function company()
    {
        return $this->belongsTo(Company::class)->withTrashed();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    /* ---------------- LOCAL SCOPES ------------------ */
    public function scopeAllowedTrash(Builder $builder)
    {
        if (request()->query('trash')) {
            $builder->onlyTrashed();
        }
        return $builder;
    }
    /* ---------------- DYNAMIC SCOPES ------------------ */

    public function scopeAllowedFilters(Builder $builder, ...$keys)
    {
        foreach ($keys as $key) {
            if ($value = request()->query($key)) {
                $builder->where($key, $value);
            }
        }

        return $builder;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
