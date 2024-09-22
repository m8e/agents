<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/goals', [App\Http\Controllers\GoalsController::class, 'index'])->name('goals');
    Route::get('/goals/{goal}', [App\Http\Controllers\GoalsController::class, 'show'])->name('goals.show');
    Route::get('/goals/{goal}/edit', [App\Http\Controllers\GoalsController::class, 'edit'])->name('goals.edit');
});
