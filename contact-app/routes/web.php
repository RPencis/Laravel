<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

function getContacts() {
    return [
        1 => ['id'=> 1,'name' => 'Name 1','phone' => '21234561' ],
        2 => ['id'=> 2,'name' => 'Name 2','phone' => '21234562' ],
        3 => ['id'=> 3,'name' => 'Name 3','phone' => '21234563' ],
    ];
}

Route::get('/', function () {
    $html = "
     ";
    // return $html;
    return view('welcome');
});
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/contacts', function () {
        $companies = [
            1 => ['name' => 'Company One', 'contacts' => 3],
            2 => ['name' => 'Company Two', 'contacts' => 5]
        ];
        $contacts = getContacts();
        return view('contacts.index', compact('contacts','companies'));
    })->name('contacts.index');

    Route::get('/contacts/create', function () {
        return view('contacts.create');
    })->name('contacts.create');

    Route::get('/contacts/{id}', function ($contactId) {
        $contacts = getContacts();
        //abort_if(!isset($contacts[$contactId]),404);//returns 404 if id doesnt exist
        abort_unless(isset($contacts[$contactId]),404);//returns 404 if id doesnt exist
        $contact = $contacts[$contactId];
        return view('contacts.show',)->with('contact',$contact);
    })->name('contacts.show')
    ->whereNumber('id');

    //optional param
    Route::get('/companies/{name?}', function ($company = null) {
        //return view('welcome');
        if(!is_null($company)){
            return "<h1>Company $company </h1>";
        }else{
            return "<h1>All companies</h1>";
        }
    })
    ->whereAlphaNumeric('name');
    //->where('name','[a-zA-Z]+');
});

Route::fallback(function () {
    return "<h1>Sorry, the page does not exist</h1>";
});