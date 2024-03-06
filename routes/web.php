<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Models\Admin;

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
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/{id}',[AdminController::class,'show'])->name('admin.show');
    Route::get('/admin', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/{id}', [AdminController::class,'edit'])->name('admin.edit');
    Route::patch('/admin/{id}', [AdminController::class,'update'])->name('admin.update');
    Route::delete('/admin/{id}', [AdminController::class, 'destory'])->name('admin.destory');
});

Route::middleware(['auth', 'customer'])->group(function () {
    // Customer routes go here
    Route::get('/customer', [CustomerController::class, 'index']);
});