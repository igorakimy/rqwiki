<?php

use App\Http\Controllers\Categories\CategoryController;
use App\Http\Controllers\Images\ImageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->name('home');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

// Categories
Route::resource('categories', CategoryController::class)
    ->only(['index', 'show']);

// Images
Route::resource('images', ImageController::class);
