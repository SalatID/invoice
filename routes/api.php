<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/inv/add',[InvController::class,'add']);
Route::post('/inv/detail/add',[InvController::class,'addDetail']);
Route::post('/inv/get',[InvController::class,'getList']);
Route::put('/inv/detail/qty/update',[InvController::class,'updQty']);
Route::delete('/inv/detail/delete',[InvController::class,'delInv']);
