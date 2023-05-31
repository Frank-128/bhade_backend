<?php

use App\Http\Controllers\MetreController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);


Route::post('/addTenant',[TenantController::class,'add']);
Route::middleware(['auth:sanctum'])->group(function(){

Route::get('/getTenant/{id}',[TenantController::class,'getOne']);
Route::get('/getAllTenants',[TenantController::class,'getAll']);
Route::put('/updateTenant/{id}', [TenantController::class, 'updateTenant']);
Route::post('/addMetre', [MetreController::class, 'add']);
Route::put('/updateMetre/{id}', [MetreController::class, 'update']);
Route::get('/getMetre', [MetreController::class, 'view']);
Route::get('/getOneMetre/{id}', [MetreController::class, 'viewOne']);
Route::put('/updateRoom/{id}',[RoomController::class,"update"]);
Route::get('/viewRooms',[RoomController::class,"view"]);
Route::get('/viewOneRoom/{id}',[RoomController::class,"viewOne"]);
});
Route::post('/addRoom',[RoomController::class,"add"]);
