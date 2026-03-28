<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware([SetLocale::class])->group(function () {
    Route::get('/', [HomeController::class , 'index'])->name('home');
    Route::get('/api/cars/search', [HomeController::class , 'searchAjax'])->name('cars.search');
    Route::get('/api/cars/count', [HomeController::class , 'getCount'])->name('cars.count');
    Route::get('/favorites', [HomeController::class , 'favorites'])->name('favorites');
    Route::post('/api/cars/favorites', [HomeController::class , 'getFavorites'])->name('api.favorites');
    Route::get('/cars/{car}', [HomeController::class , 'show'])->name('cars.show');

    Route::get('/locale/{locale}', function (string $locale) {
            if (in_array($locale, ['en', 'de'], true)) {
                session(['locale' => $locale]);
            }

            return back();
        }
        )->name('locale.switch');

        // Secret Admin Login Route (Protected by Token)
        Route::middleware(['admin_token'])->group(function () {
            Route::get('/' . env('ADMIN_LOGIN_PATH', 'portal-access-admin-login-159-753'), [\App\Http\Controllers\Auth\LoginController::class , 'showLoginForm'])->name('login');
            Route::post('/' . env('ADMIN_LOGIN_PATH', 'portal-access-admin-login-159-753'), [\App\Http\Controllers\Auth\LoginController::class , 'login'])->middleware('throttle:3,1');
        }
        );

        Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class , 'logout'])->name('logout');

        // Admin Dashboard (Protected by Auth + Admin Role + Token)
        Route::middleware(['auth', 'admin', 'admin_token'])->prefix(env('ADMIN_PREFIX', '!admin-021405'))->group(function () {
            Route::get('/dashboard', [AdminController::class , 'dashboard'])->name('admin.dashboard');
            Route::get('/cars/create', [AdminController::class , 'create'])->name('admin.cars.create');
            Route::post('/cars', [AdminController::class , 'store'])->name('admin.cars.store');
            Route::get('/cars/{car}/edit', [AdminController::class , 'edit'])->name('admin.cars.edit');
            Route::put('/cars/{car}', [AdminController::class , 'update'])->name('admin.cars.update');
            Route::delete('/cars/{car}', [AdminController::class , 'destroy'])->name('admin.cars.destroy');
            Route::delete('/cars/{car}/delete-image/{index}', [AdminController::class , 'deleteImage'])->name('admin.cars.delete-image');
            Route::get('/settings', [AdminController::class , 'settings'])->name('admin.settings');
            Route::put('/settings', [AdminController::class , 'updateSettings'])->name('admin.settings.update');
        }
        );
    });