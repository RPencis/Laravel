<?php

namespace App\Http\Controllers;

use App\Models\Contact;
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
        $companies = $company->pluck();
        
        $contacts = Contact::allowedTrash()
            ->allowedSorts(['first_name','last_name','email'],'-id')
            ->allowedFilters('company_id')
            ->allowedSearch('first_name','last_name','email')
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

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            //'first_name' => ['required','string','max:50'],
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'company_id' => 'required|exists:companies,id',
        ]);

        $contact = Contact::create($request->all());

        //return $contact;//return json response

        return redirect()->route("contacts.index")->with('message', 'Contact has been added successfully');
    }

    public function create()
    {
        $companies = $this->company->pluck();

        $contact = new Contact();
        return view('contacts.create', compact('companies', 'contact'));
    }

    public function show(Request $request, string $id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.show', )->with('contact', $contact);
    }

    public function edit(Request $request, string $id)
    {
        $companies = $this->company->pluck();
        $contact = Contact::findOrFail($id);
        return view('contacts.edit', compact('companies', 'contact'));
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:50',
            //'first_name' => ['required','string','max:50'],
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'company_id' => 'required|exists:companies,id',
        ]);

        $contact->update($request->all());

        //return $contact;//return json response

        return redirect()->route("contacts.index")->with('message', 'Contact has been updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $contact->delete();
        $redirect = request()->query('redirect');
        return ($redirect ? redirect()->route($redirect) : back())
            ->with('message', 'Contact has been moved to trash.')
            ->with('undoRoute', $this->getUndoRoute('contacts.restore', $contact));
    }
    public function restore(Request $request, $id)
    {
        $contact = Contact::onlyTrashed()->findOrFail($id);

        $contact->restore();

        return back()
            ->with('message', 'Contact has been restored from trash.')
            ->with('undoRoute', $this->getUndoRoute('contacts.destroy', $contact));
    }

    protected function getUndoRoute($name, $resource)
    {
        return request()->missing('undo') ? route($name, [$resource->id, 'undo' => true]) : null;
    }

    public function forceDelete(Request $request, $id)
    {
        $contact = Contact::onlyTrashed()->findOrFail($id);

        $contact->forceDelete();

        return back()
            ->with('message', 'Contact has been removed permanently');
    }
}
