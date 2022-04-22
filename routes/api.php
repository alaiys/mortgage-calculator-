<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BankController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/banks', [BankController::class, 'getBanks']);
Route::post('/bank', [BankController::class, 'addBank']);
Route::get('/bank/{id}', [BankController::class, 'getBank']);
Route::post('/bank/{id}', [BankController::class, 'updateBank']);
Route::delete('/bank/{id}', [BankController::class, 'deleteBank']);
