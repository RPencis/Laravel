<?php

namespace App\Models;

use App\Models\Scopes\AllowedFilterSearch;
use App\Models\Scopes\AllowedFilterSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes, AllowedFilterSearch, AllowedFilterSort;


    // protected $table = "app_companies";// specify table if the table doesnt folow the naming scheme of elequent
    // protected $primaryKey = "_id";// specify primary key if it is not id

    // protected $guarded = [];//columns that cant bee mass assigned;
    protected $fillable = ['email', 'name', 'address','website'];//columns that can be used for mass assigned, others will be ignored

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
