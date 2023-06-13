<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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

        //$contacts = Contact::latest()->paginate(10);

        //manual pagination
        $contactsCollection = Contact::latest()->get();
        $perPage = 10;
        $currentPage = request()->query('page', 1);
        $items = $contactsCollection->slice(($currentPage * $perPage) - $perPage, $perPage);// (1 * 10) - 10 = 0 
        $total = $contactsCollection->count();
        $contacts = new LengthAwarePaginator($items,$total,$perPage,$currentPage,[
                'path' => request()->url(),
                'query' => request()->query()
        ]);
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
