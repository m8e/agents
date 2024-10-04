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

    Route::get('/goals', [App\Http\Controllers\GoalsController::class, 'index'])->name('goals.index');
    Route::get('/goals/onboarding', [App\Http\Controllers\GoalsController::class, 'onboarding'])->name('goals.onboarding');
    Route::get('/goals/create', [App\Http\Controllers\GoalsController::class, 'create'])->name('goals.create');
    Route::post('/goals/store', [App\Http\Controllers\GoalsController::class, 'store'])->name('goals.store');
    Route::get('/goals/{goal}', [App\Http\Controllers\GoalsController::class, 'show'])->name('goals.show');
    Route::get('/goals/{goal}/edit', [App\Http\Controllers\GoalsController::class, 'edit'])->name('goals.edit');
});
