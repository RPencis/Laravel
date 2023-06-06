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

Route::get('/', function () {
    $html = "<h1>Contact App</h1>
    <div>
        <a href='".route('admin.contacts.index')."'>All contacts </a>
        <a href='".route('admin.contacts.create')."'>Add contact </a>
        <a href='".route('admin.contacts.show',1)."'> Show contact </a>
    </div>
    ";
    return $html;
    //return view('welcome');
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/contacts', function () {
        //return view('welcome');
        return "<h1> All contacts </h1>";
    })->name('contacts.index');

    Route::get('/contacts/create', function () {
        //return view('welcome');
        return "<h1> Add new contacts </h1>";
    })->name('contacts.create');

    Route::get('/contacts/{id}', function ($contactId) {
        //return view('welcome');
        return "<h1>Contact $contactId </h1>";
    })->whereNumber('id')
    ->name('contacts.show');
    //->where('id','[0-9]+');

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