<?php

use App\Http\Controllers\Categories\CategoryController;
use App\Http\Controllers\Images\ImageController;
use App\Http\Controllers\Locations\LocationController;
use App\Http\Controllers\Locations\LocationTypeController;
use App\Http\Controllers\WorldMap\WorldMapController;
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

// WorldMap
Route::get('/world-map', [WorldMapController::class, 'index'])
    ->name('world-map.index');

// Locations
Route::resource('locations', LocationController::class);

// Location types
Route::resource('location-types', LocationTypeController::class);
