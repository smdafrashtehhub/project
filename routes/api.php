<?php

use App\Http\Controllers\Api\FactorController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\MailController;
use App\Http\Controllers\Api\SendEmail as SendEmail;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SmsController;
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

Route::post('/location/{order}',[LocationController::class,'location']);

Route::get('/users/send_email', [SendEmail::class, 'sendemail']);
Route::get('/users/sendemail', [MailController::class, 'sendemail']);
Route::post('/users/store', [UserController::class, 'store']);
//Route::get('/users/index',[UserController::class,'index'])->middleware('auth:sanctum')->middleware('permission:admin');
Route::get('/users/index', [UserController::class, 'index'])->middleware('auth:sanctum')->middleware('permission:User_index');
Route::post('/users/login', [UserController::class, 'login']);
Route::get('/users/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::delete('/users/{id}/delete', [UserController::class, 'destroy'])->middleware('auth:sanctum')->middleware('web_permission:admin');
//Route::get('/users/{user}/show',[UserController::class,'show'])->middleware('auth:sanctum');
Route::get('/users/{user}/show', [UserController::class, 'show'])->middleware('auth:sanctum')->middleware('role:admin|seller|customer');
Route::post('/users/{id}/update', [UserController::class, 'update'])->middleware('auth:sanctum')->middleware('role:admin|seller|customer');
Route::post('/users/register', [UserController::class, 'register']);
Route::post('/users/{user}/confirmed', [UserController::class, 'confirmed'])->middleware('auth:sanctum')->middleware('role:admin');
Route::post('/users/Awaiting_confirmation', [UserController::class, 'Awaiting_confirmation'])->middleware('role:admin');
Route::post('users/filter', [UserController::class, 'filter'])->middleware('auth:sanctum')->middleware('role:admin');


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products/index', [ProductController::class, 'index'])->middleware('role:admin|seller');
    Route::post('/products/create', [ProductController::class, 'create'])->middleware('role:admin|seller');
    Route::post('/products/{product}/update', [ProductController::class, 'update'])->middleware('role:admin|seller');
    Route::delete('/products/{product}/destroy', [ProductController::class, 'destroy'])->middleware('role:admin|seller');
    Route::post('/products/filter', [ProductController::class, 'filter'])->middleware('role:admin|seller');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/orders/index', [OrderController::class, 'index'])->middleware('role:admin|seller|customer');
    Route::post('/orders/create', [OrderController::class, 'create'])->middleware('role:admin|seller|customer');
    Route::delete('/orders/{order}/destroy', [OrderController::class, 'destroy'])->middleware('role:admin|seller|customer');
    Route::put('/orders/{order}/update', [OrderController::class, 'update'])->middleware('role:admin|seller|customer');
    Route::post('/orders/filter', [OrderController::class, 'filter'])->middleware('role:admin|seller|customer');

});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/factors/index', [FactorController::class, 'index'])->middleware('role:admin');
    Route::post('/factors/create', [FactorController::class, 'create'])->middleware('role:admin');
    Route::delete('/factors/{factor}/destroy', [FactorController::class, 'destroy'])->middleware('role:admin');
    Route::post('/factors/{factor}/update', [FactorController::class, 'update'])->middleware('role:admin');
    Route::post('/factors/filter', [FactorController::class, 'filter'])->middleware('role:admin|seller|customer');
});


Route::post('/images/create', [ImageController::class, 'create']);
Route::get('/sendsms', [SmsController::class, 'sendsms']);
