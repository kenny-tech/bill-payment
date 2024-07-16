<?php

use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [UserAuthController::class, 'register'])->name('register');
Route::post('login', [UserAuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->prefix('user')->group(function () {
    Route::get('/get-transactions', [TransactionController::class, 'getTransactions'])->name('transactions.get');
    Route::post('/create-transaction', [TransactionController::class, 'createTransaction'])->name('transactions.create');
    Route::put('/update-transaction/{transaction}', [TransactionController::class, 'updateTransaction'])->name('transactions.update');
    Route::delete('/delete_transaction/{transaction}', [TransactionController::class, 'deleteTransaction'])->name('transactions.destroy');
});

