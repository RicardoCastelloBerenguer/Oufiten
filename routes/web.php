<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileControllerDelete;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['guestOrVerified'])->group(function (){
    Route::get('/', [ProductController::class,'index'])->name('home');
    Route::get('/product/{product:slug}', [ProductController::class,'show'])->name('product.view');

    Route::prefix('/cart')->name('cart.')->group(function(){
        Route::get('/', [CartController::class,'index'])->name('index');
        Route::post('/add/{product:slug}', [CartController::class,'add'])->name('add');
        Route::post('/remove/{product:slug}', [CartController::class,'remove'])->name('remove');
        Route::post('/update-quantity/{product:slug}', [CartController::class,'updateQuantity'])->name('update-quantity');
    });
});


Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/profile', [ProfileController::class, 'view'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.update');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});


Route::get('/products', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');




/*Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileControllerDelete::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileControllerDelete::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileControllerDelete::class, 'destroy'])->name('profile.destroy');
});*/

require __DIR__.'/auth.php';
