<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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


Route::middleware('blocked')->group(function () {

    // Only logged-in users can create/edit/delete events, comment, rate, register
    Route::middleware('auth')->group(function () {

        Route::get('/events/create', [EventController::class, 'create'])
            ->name('events.create');

        Route::post('/events', [EventController::class, 'store'])
            ->name('events.store');

        Route::get('/events/{event}/edit', [EventController::class, 'edit'])
            ->name('events.edit');
        
        Route::put('/events/{event}', [EventController::class, 'update'])
            ->name('events.update');
        
        Route::delete('/events/{event}', [EventController::class, 'destroy'])
            ->name('events.destroy');

        Route::post('/events/{event}/comments', [CommentController::class, 'store'])
            ->name('comments.store');

        Route::delete('/events/{comment}/remcomment', [CommentController::class, 'destroy'])
            ->name('comments.destroy');

        Route::post('/events/{event}/ratings', [RatingController::class, 'store'])
            ->name('ratings.store');

        Route::post('/events/{event}/register', [RegistrationController::class, 'store'])
            ->name('registrations.store');
            
        Route::get('/users/edit', [UserController::class, 'edit'])
            ->name('users.edit');

        Route::put('/users', [UserController::class, 'update'])
            ->name('users.update');
    });

    // Later this will be protected by admin middleware
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::resource('categories', CategoryController::class);

        Route::get('/users', [UserController::class, 'index'])
            ->name('users.index');

        Route::post('/users/{user}/block', [UserController::class, 'block'])
            ->name('users.block');

        Route::post('/users/{user}/unblock', [UserController::class, 'unblock'])
            ->name('users.unblock');

    });


    // Public event pages
    Route::get('/events', [EventController::class, 'index'])
        ->name('events.index');

    Route::get('/events/{event}', [EventController::class, 'show'])
        ->name('events.show');

});