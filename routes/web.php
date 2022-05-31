<?php

use App\Enums\CurrencySymbol;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\UserController::class, 'getUserTransactionHistory'])->name('home');
Route::post('/assign-wallet-to-user', [App\Http\Controllers\UserController::class, 'addWalletToUser'])->name('assign.wallet.to.user');
Route::post('/store-transactions', [App\Http\Controllers\TransactionController::class, 'createTransaction'])->name('create.transaction');
