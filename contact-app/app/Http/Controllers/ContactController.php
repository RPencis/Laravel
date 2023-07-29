<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    protected function userCompanies(){
        return Company::forUser(auth()->user())->orderBy('name')->pluck('name','id');
    }

    // public function __construct(CompanyRepository $company)
    // {
    //     $this->company = $company;
    // }

    public function index(Request $request)
    {
        $companies = $this->userCompanies();
        
        $contacts = Contact::allowedTrash()
            ->allowedSorts(['first_name','last_name','email'],'-id')
            ->allowedFilters('company_id')
            ->allowedSearch('first_name','last_name','email')
            ->forUser(auth()->user())
            ->paginate(10);

        //manual pagination
        // $contactsCollection = Contact::latest()->get();
        // $perPage = 10;
        // $currentPage = request()->query('page', 1);
        // $items = $contactsCollection->slice(($currentPage * $perPage) - $perPage, $perPage);// (1 * 10) - 10 = 0
        // $total = $contactsCollection->count();
        // $contacts = new LengthAwarePaginator($items,$total,$perPage,$currentPage,[
        //         'path' => request()->url(),
        //         'query' => request()->query()
        // ]);
        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function store(ContactRequest $request)
    {
        $contact = $request->user()->contacts()->create($request->all());

        return redirect()->route("contacts.index")->with('message', 'Contact "'.$contact->first_name.' '.$contact->last_name.'" has been added successfully');
    }

    public function create()
    {
        $companies = $this->userCompanies();

        $contact = new Contact();
        return view('contacts.create', compact('companies', 'contact'));
    }

    public function show(Contact $contact)
    {
        return view('contacts.show', )->with('contact', $contact);
    }

    public function edit(Contact $contact)
    {
        $companies = $this->userCompanies();
        return view('contacts.edit', compact('companies', 'contact'));
    }

    public function update(ContactRequest $request, Contact $contact)
    {
        $contact->update($request->all());

        return redirect()->route("contacts.index")->with('message', 'Contact has been updated successfully');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        $redirect = request()->query('redirect');
        return ($redirect ? redirect()->route($redirect) : back())
            ->with('message', 'Contact has been moved to trash.')
            ->with('undoRoute', $this->getUndoRoute('contacts.restore', $contact));
    }
    public function restore(Contact $contact)
    {
        $contact->restore();

        return back()
            ->with('message', 'Contact has been restored from trash.')
            ->with('undoRoute', $this->getUndoRoute('contacts.destroy', $contact));
    }

    protected function getUndoRoute($name, $resource)
    {
        return request()->missing('undo') ? route($name, [$resource->id, 'undo' => true]) : null;
    }

    public function forceDelete(Contact $contact)
    {
        $contact->forceDelete();

        return back()
            ->with('message', 'Contact has been removed permanently');
    }
}
