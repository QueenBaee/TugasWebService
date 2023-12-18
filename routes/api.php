<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PesananController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\CheckUserLogin;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/pesanan',[PesananController::class,'create']);
    Route::put('/pesanan/{kode_pesanan}',[PesananController::class,'update']);
    Route::delete('/pesanan/{kode_pesanan}',[PesananController::class,'delete']);
});

Route::get('/pesanan',[PesananController::class,'index']);
Route::get('/pesanan/{kode_pesanan}',[PesananController::class,'findById']);
