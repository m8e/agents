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

    Route::get('/objectives', [App\Http\Controllers\ObjectivesController::class, 'index'])->name('objectives');
    Route::get('/objectives/{objective}', [App\Http\Controllers\ObjectivesController::class, 'show'])->name('objectives.show');
    Route::get('/objectives/{objective}/edit', [App\Http\Controllers\ObjectivesController::class, 'edit'])->name('objectives.edit');
});
