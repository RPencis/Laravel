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
use App\Models\User;
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
    Route::delete('/companies/{company}/restore', [CompanyController::class, 'restore'])
        ->withTrashed()
        ->name('companies.restore');
    Route::delete('/companies/{company}/force-delete', [CompanyController::class, 'forceDelete'])
        ->withTrashed()
        ->name('companies.force-delete');
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

Route::get('/eagerload-multiple', function(){
    $users = User::with(["companies","contacts"])//eager load multiple relationship model
    ->get();

    foreach($users as $user){
        echo $user->name . ": ";
        echo $user->companies->count() ." companies, " .$user->contacts->count() . " contacts<br>";
    }
});

Route::get('/eagerload-nested', function(){
    $users = User::with(["companies","companies.contacts"])->get();//nested relationship. since companies ar linked to contacts

    foreach($users as $user){
        echo $user->name . "<br />";
        foreach($user->companies as $company){
            echo $company->name . " has ". $company->contacts->count(). " contacts <br />";
        }
        echo "<br />";
    }
});

Route::get('/eagerload-constraint', function(){
    $users = User::with(["companies" => function($query) {
        $query->where('email','like','%.org');//filtering the relationship data
    }])->get();

    foreach($users as $user){
        echo $user->name . "<br />";
        foreach($user->companies as $company){
            echo $company->email . "<br />";
        }
        echo "<br />";
    }
});

Route::get('/eagerload-lazy', function(){
    $users = User::get();
    $users->load(['companies' => function($query){
        $query->orderBy('name');
    }]);
    foreach($users as $user){
        echo $user->name . "<br />";
        foreach($user->companies as $company){
            echo $company->name . "<br />";
        }
        echo "<br />";
    }
});

Route::get('/eagerload-default', function(){
    $users = User::without('contacts')->get();
    
    foreach($users as $user){
        echo $user->name . "<br />";
        foreach($user->companies as $company){
            echo $company->email . "<br />";
        }
        echo "<br />";
    }
});

Route::get('/count-models', function(){
    //! withCount() HAS TO BE AFTER THE SELECT METHOD
    // $users = User::withCount([
    //     'contacts as contacts_number',
    //     'companies as companies_count_end_with_gmail' => function($query){
    //         $query->where('email','like','%@gmail.com');
    //     }
    //     ])->get();
    
    // foreach($users as $user){
    //     echo $user->name . "<br />";
    //     echo $user->companies_count_end_with_gmail ." companies<br />";
    //     echo $user->contacts_number ." contacts<br />";
    //     echo "<br />";
    // }
    
    $users = User::get();
    $users->loadCount(['companies'=> function($query){
            $query->where('email','like','%@gmail.com');
    }]);
    foreach($users as $user){
        echo $user->name . "<br />";
        echo $user->companies_count ." companies<br />";
        echo "<br />";
    }
});