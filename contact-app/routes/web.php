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

Route::resource('/contacts', ContactController::class);

Route::resource('/companies', CompanyController::class);

Route::resources([
    '/tags' => TagController::class,
    '/tasks' => TaskController::class,
]);

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
