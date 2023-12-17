<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PesananController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/pesanan',[PesananController::class,'index']);
Route::get('/pesanan/{kode_pesanan}',[PesananController::class,'findById']);
Route::post('/pesanan',[PesananController::class,'create']);
Route::put('/pesanan/{kode_pesanan}',[PesananController::class,'update']);
Route::delete('/pesanan/{kode_pesanan}',[PesananController::class,'delete']);
