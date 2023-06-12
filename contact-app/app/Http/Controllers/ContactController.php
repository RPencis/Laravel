<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use App\Models\Contact;

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

        $contacts = Contact::latest()->get();
        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function show(Request $request, string $id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.show', )->with('contact', $contact);
    }
}
