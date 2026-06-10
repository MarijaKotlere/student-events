<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('events.index');
});

// Auth routes
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.store');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// Public event pages
Route::resource('events', EventController::class)
    ->only(['index', 'show']);

// Only logged-in users can create/edit/delete events, comment, rate, register
Route::middleware('auth')->group(function () {
    Route::resource('events', EventController::class)
        ->except(['index', 'show']);

    Route::post('/events/{event}/comments', [CommentController::class, 'store'])
        ->name('comments.store');

    Route::post('/events/{event}/ratings', [RatingController::class, 'store'])
        ->name('ratings.store');

    Route::post('/events/{event}/register', [RegistrationController::class, 'store'])
        ->name('registrations.store');
});

// Later this will be protected by admin middleware
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
});