<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('Home');
});

//Show all users
Route::get('/users', [UserController::class, 'index'])
    ->name('users.index')->middleware('auth');
//Show form to create a new user
Route::get('/users/create', [UserController::class, 'create'])
    ->name('users.create');
//Store a new user
Route::post('/users', [UserController::class, 'store'])
    ->name('users.store');
//Show a specific user
Route::get('/users/{id}', [UserController::class, 'show'])
    ->name('users.show')->middleware('auth');
//Show form to edit a user
Route::get('/users/{id}/edit', [UserController::class, 'edit'])
    ->name('users.edit')->middleware('auth');
//Restore a soft-deleted user
Route::get('/users/{id}/restore', [UserController::class, 'restore'])
     ->name('users.restore')->middleware('signed');

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

});

require __DIR__.'/auth.php';