<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VerifyPaymentController;
use Illuminate\Support\Facades\Auth;
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

Route::group(['middleware' => ['auth']], function () {
    Route::get('/payments/{reference}/retry', [VerifyPaymentController::class, 'retry'])
        ->name('payments.retry');

    });
    Route::get('/payments/{reference}/verify', [VerifyPaymentController::class, 'verify'])
        ->name('payments.verify');

    Route::get('transactions/{transaction}', [TransactionController::class, 'show'])
        ->name('transactions.show');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

