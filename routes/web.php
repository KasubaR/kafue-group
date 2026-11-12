<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\QuoteAdminController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/products', [PageController::class, 'products'])->name('products');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::post('/quote', [QuoteController::class, 'store'])
    ->middleware('throttle:5,1') // 5 submissions per minute per visitor
    ->name('quote.store');

/* Admin: quote requests (sign in with a user made by `php artisan admin:create`) */
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'create'])->name('login');
        Route::post('login', [AuthController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
    });

    Route::middleware('auth')->group(function () {
        Route::redirect('/', '/admin/quotes');
        Route::post('logout', [AuthController::class, 'destroy'])->name('logout');
        Route::get('quotes', [QuoteAdminController::class, 'index'])->name('quotes.index');
        Route::get('quotes/{quote}', [QuoteAdminController::class, 'show'])->name('quotes.show');
        Route::post('quotes/{quote}/handled', [QuoteAdminController::class, 'toggleHandled'])->name('quotes.handled');
        Route::get('quotes/{quote}/attachment', [QuoteAdminController::class, 'attachment'])->name('quotes.attachment');
    });
});
