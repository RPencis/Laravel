<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactNoteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class);
    
    Route::get('/settings/profile-information', ProfileController::class)->name('user-profile-information.edit');
    Route::get('/settings/password', PasswordController::class)->name('user-password.edit');
    
    Route::resource('/contacts', ContactController::class);
    Route::delete('/contacts/{contact}/restore', [ContactController::class, 'restore'])
        ->withTrashed()
        ->name('contacts.restore');
    Route::delete('/contacts/{contact}/force-delete', [ContactController::class, 'forceDelete'])
        ->withTrashed()
        ->name('contacts.force-delete');

    Route::resource('/companies', CompanyController::class);
});

Route::resources([
    '/tags' => TagController::class,
    '/tasks' => TaskController::class,
]);

Route::resource('/activities', ActivityController::class)
    ->parameters([ //change param name
        'activities' => 'active',
    ])
;

//nested e.g. /contacts/{contact}/notes
Route::resource('/contacts.notes', ContactNoteController::class)
    ->shallow();

Route::fallback(function () {
    return "<h1>Sorry, the page does not exist</h1>";
});


Route::get('/download', function(){
    return Storage::download('myfile.txt');
});