<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // protected $table = "app_companies";// specify table if the table doesnt folow the naming scheme of elequent
    // protected $primaryKey = "_id";// specify primary key if it is not id

    // protected $guarded = [];//columns that cant bee mass assigned;
    protected $fillable = ['email', 'name', 'address','website'];//columns that can be used for mass assigned, others will be ignored

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
