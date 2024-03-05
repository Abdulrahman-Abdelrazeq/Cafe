<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\StripeController;


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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home',[HomeController::class,'index'])->middleware('auth')->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'admin'])->group(function () {
    // Admin routes go here
    Route::get('/admin', [AdminController::class, 'index']);
});

Route::middleware(['auth', 'customer'])->group(function () {
    // Customer routes go here
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer');

    Route::post('/add-to-cart/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/remove-from-cart/{productId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/{id}/increase', [CartController::class, 'increaseQuantity'])->name('cart.increase');
    Route::post('/cart/{id}/reduce', [CartController::class, 'reduceQuantity'])->name('cart.reduce');

    Route::post('/session', [StripeController::class, 'session'])->name('session');
    Route::get('/success', [StripeController::class, 'success'])->name('success');
    Route::get('/cancel', [StripeController::class, 'cancel'])->name('cancel');

    Route::get('/myorders', [CustomerController::class, 'orders'])->name('myorders');
});
