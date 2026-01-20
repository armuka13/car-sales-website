<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/favorites', [HomeController::class, 'favorites'])->name('favorites');
Route::post('/api/cars/favorites', [HomeController::class, 'getFavorites'])->name('api.favorites');

Auth::routes(['register' => false]); // Disable registration

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/cars/create', [AdminController::class, 'create'])->name('admin.cars.create');
    Route::post('/cars', [AdminController::class, 'store'])->name('admin.cars.store');
    Route::get('/cars/{car}/edit', [AdminController::class, 'edit'])->name('admin.cars.edit');
    Route::put('/cars/{car}', [AdminController::class, 'update'])->name('admin.cars.update');
    Route::delete('/cars/{car}', [AdminController::class, 'destroy'])->name('admin.cars.destroy');
    Route::delete('/cars/{car}/delete-image/{index}', [AdminController::class, 'deleteImage'])->name('admin.cars.delete-image');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
});