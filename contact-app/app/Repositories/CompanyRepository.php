<?php

namespace App\Repositories;
use App\Models\Company;

class CompanyRepository
{
    public function pluck()
    {
        //return Company::orderBy('name')->pluck('name','id');

        $data = [];

        $companies = Company::orderBy('name')->get();

        foreach($companies as $company){
            $count = $company->contacts()->count();
            $data[$company->id] = "$company->name ( $count  )";
        }

        return $data;
    }
}
