<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvController;
use App\Http\Controllers\ItemController;

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

Route::get('/',[InvController::class,'index']);
Route::get('/inv/add',[InvController::class,'addPage']);
Route::get('/inv/edit',[InvController::class,'editPage']);
Route::get('/inv/detail',[InvController::class,'invPdf']);

Route::get('/item/get',[ItemController::class,'getList']);
