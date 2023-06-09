<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactNoteController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WelcomeController;
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

Route::get('/', WelcomeController::class);

// example of nesting
// Route::prefix('admin')->name('')->group(function () {
//     Route::controller(ContactController::class)->name('contacts.')->group(
//         function () {
//             Route::get('/contacts', 'index')
//                 ->name('index');

//             Route::get('/contacts/create', 'create')
//                 ->name('create');

//             Route::get('/contacts/{id}', 'show')
//                 ->name('show')->whereNumber('id');
//         }
//     );
// });

Route::controller(ContactController::class)->name('contacts.')->group(
    function () {
        Route::get('/contacts', 'index')
            ->name('index');

        Route::get('/contacts/create', 'create')
            ->name('create');

        Route::get('/contacts/{id}', 'show')
            ->name('show')->whereNumber('id');
    }
);

Route::resource('/companies', CompanyController::class);

Route::resources([
    '/tags' => TagController::class,
    '/tasks' => TaskController::class,
]);

// Route::resource('/activities', ActivityController::class)
// ->except([
//     //'create','store','edit','update','destroy' //for only
//     //'index','show'
// ])->names([
//     'index' => 'activities.all',
//     'show' => 'activities.view'
// ]);

Route::resource('/activities', ActivityController::class)
->parameters([//change param name
    'activities' => 'active'
])
;

//nested e.g. /contacts/{contact}/notes
Route::resource('/contacts.notes', ContactNoteController::class)
->shallow();


Route::fallback(function () {
    return "<h1>Sorry, the page does not exist</h1>";
});

//optional param

//->where('name','[a-zA-Z]+');
// Route::get('/companies/{name?}', function ($company = null) {
//     //return view('welcome');
//     if (!is_null($company)) {
//         return "<h1>Company $company </h1>";
//     } else {
//         return "<h1>All companies</h1>";
//     }
// })
//     ->whereAlphaNumeric('name');
