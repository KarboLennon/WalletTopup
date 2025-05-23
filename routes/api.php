<?php

use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\TopUpController;
use App\Http\Controllers\Api\TransferController;
use App\Http\Controllers\Api\TransactionReportController;
use App\Http\Controllers\Api\ProfileController;

Route::post('/register', [RegisterController::class, 'register']); 
Route::post('/login', [LoginController::class, 'login']);          

Route::middleware('auth:api')->group(function () {
    Route::post('/topup', [TopUpController::class, 'topup']);
    Route::post('/transfer', [TransferController::class, 'transfer']);
    Route::get('/transactions', [TransactionReportController::class, 'index']);
    Route::put('/profile', [ProfileController::class, 'update']);
});

