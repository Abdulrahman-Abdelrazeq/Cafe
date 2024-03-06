<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;



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
    Route::get('/orders', [AdminController::class, 'listOrders'])->name('admin.orders');
    Route::patch('/orders/{order}', [AdminController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('/checks', [AdminController::class, 'checks'])->name('admin.checks');
    Route::get('/manual-order', [AdminController::class, 'createOrder'])->name('admin.createOrder');
    Route::post('/manual-order', [AdminController::class, 'submitOrder'])->name('admin.submitOrder');

    // category
    Route::resource("categories",CategoryController::class);
    //product
    Route::resource("products",ProductController::class);



});

Route::middleware(['auth', 'customer'])->group(function () {
    // Customer routes go here
    Route::get('/customer', [CustomerController::class, 'index']);
});
