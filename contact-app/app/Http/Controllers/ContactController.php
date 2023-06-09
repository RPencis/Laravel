<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    // public function __construct(CompanyRepository $company)
    // {
    //     $this->company = $company;
    // }
     public function __construct(protected CompanyRepository $company)
     {
     }

    public function index(CompanyRepository $company, Request $request)
    {
        //dd($request->sort_by);
        $companies = $company->pluck();

        $contacts = $this->getContacts();
        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function show(Request $request, string $id)
    {
        $contacts = $this->getContacts();
        //abort_if(!isset($contacts[$contactId]),404);//returns 404 if id doesnt exist
        abort_unless(isset($contacts[$id]), 404); //returns 404 if id doesnt exist
        $contact = $contacts[$id];
        return view('contacts.show', )->with('contact', $contact);
    }

    protected function getContacts()
    {
        return [
            1 => ['id' => 1, 'name' => 'Name 1', 'phone' => '21234561'],
            2 => ['id' => 2, 'name' => 'Name 2', 'phone' => '21234562'],
            3 => ['id' => 3, 'name' => 'Name 3', 'phone' => '21234563'],
        ];
    }
}
