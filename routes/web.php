<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, "index"])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/success', [CartController::class, 'success'])->name('success');
Route::get('/register/success', [RegisterController::class, 'success'])->name('register-success');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout');
Route::post('/checkout/callback', [CheckoutController::class, 'callback'])->name('midtrans-callback');

Route::prefix('categories')->group(
    function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories');
        Route::get('/{id}', [CategoryController::class, 'detail'])->name('categories-detail');
    }
);

Route::prefix('details')->group(
    function () {
        Route::get('/{id}', [DetailController::class, 'index'])->name('detail');
        Route::post('/{id}', [DetailController::class, 'add'])->name('detail-add');
    }
);

Route::prefix('cart')
    ->middleware(['auth'])
    ->group(
        function () {
            Route::get('/', [CartController::class, 'index'])->name('cart');
            Route::delete('/{id}', [CartController::class, 'delete'])->name('cart-delete');
        }
    );

Route::prefix('dashboard/products')
    ->middleware(['auth'])
    ->group(
        function () {
            Route::get('/', [DashboardProductController::class, 'index'])->name('dashboard-product');
            Route::post('/', [DashboardProductController::class, 'store'])->name('dashboard-product-store');
            Route::get('/create', [DashboardProductController::class, 'create'])->name('dashboard-product-create');
            Route::get('/{id}', [DashboardProductController::class, 'details'])->name('dashboard-product-details');
            Route::post('/{id}', [DashboardProductController::class, 'update'])->name('dashboard-product-update');
        }
    );

Route::prefix('dashboard/products/gallery')
    ->middleware(['auth'])
    ->group(
        function () {
            Route::post('/upload', [DashboardProductController::class, 'uploadGallery'])->name('dashboard-product-gallery-upload');
            Route::get('/delete/{id}', [DashboardProductController::class, 'deleteGallery'])->name('dashboard-product-gallery-delete');
        }
    );

Route::prefix('dashboard/transactions')
    ->middleware(['auth'])
    ->group(
        function () {
            Route::get('/', [DashboardTransactionController::class, 'index'])->name('dashboard-transaction');
            Route::get('/{id}', [DashboardTransactionController::class, 'details'])->name('dashboard-transaction-details');
            Route::post('/{id}', [DashboardTransactionController::class, 'update'])->name('dashboard-transaction-update');
        }
    );

Route::prefix('dashboard/settings')
    ->middleware(['auth'])
    ->group(
        function () {
            Route::get('/', [DashboardSettingController::class, 'store'])->name('dashboard-settings-store');
            Route::post('/update/{redirect}', [DashboardSettingController::class, 'update'])->name('dashboard-settings-redirect');
        }
    );

Route::prefix('dashboard/accounts')
    ->middleware(['auth'])
    ->group(
        function () {
            Route::get('/', [DashboardSettingController::class, 'account'])->name('dashboard-settings-account');
        }
    );

Route::prefix('admin')
    ->middleware(['auth'])
    ->group(
        function () {
            Route::get('/', [Admin\DashboardController::class, 'index'])->name('admin-dashboard');

            Route::resource('category', Admin\CategoryController::class);
            Route::resource('user', Admin\UserController::class);
            Route::resource('product', Admin\ProductController::class);
            Route::resource('product-gallery', Admin\ProductGalleryController::class);
            Route::resource('transaction', Admin\TransactionController::class);
        }
    );

Auth::routes();
