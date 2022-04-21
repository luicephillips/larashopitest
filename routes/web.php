<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ShopifyController;
use App\Http\Controllers\ShopController;

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

// Route::get('/', function () {
//     return view('welcome');
// })->middleware(['verify.shopify'])->name('home');

// Route::get('/', [ShopifyController::class, 'index'])->middleware(['verify.shopify'])->name('home');

// Route::get('/', [ShopController::class, 'index'])->middleware(['verify.shopify'])->name('home');

Route::get('/', function() {
    echo 'hello';
})->middleware(['verify.shopify'])->name('home');