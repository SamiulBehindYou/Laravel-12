<?php

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::controller(UserController::class)->group(function () {
        Route::get('/dashboard', 'Dashboard')->name('dashboard');
        Route::post('/store', 'store')->name('store');
        Route::put('/update/{user}', 'update')->name('update');

        Route::delete('users/{id}', 'destroy')->name('user.destroy');
    });

});
