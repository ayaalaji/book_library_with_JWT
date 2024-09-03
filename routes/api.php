<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\RatingController;

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
Route::post('register',[AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);
Route::post('refresh', [AuthController::class,'refresh']);
///////////////Book//////////
Route::get('books',[BookController::class,'index']);
Route::get('book/{book}',[BookController::class,'show']);
//////Category//////
Route::get('categories',[CategoryController::class,'index']);
//Routes needed api (JWT)
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class,'logout']);
    Route::controller(BookController::class)->group(function(){
        Route::post('books',[BookController::class,'store']);
        Route::put('book/{book}',[BookController::class,'update']);
        Route::delete('book/{book}',[BookController::class,'destroy']);
    });
    Route::controller(RatingController::class)->group(function(){
        Route::post('rating',[RatingController::class,'store']);
        Route::put('rating/{rating}',[RatingController::class,'update']);
        Route::delete('rating/{rating}',[RatingController::class,'destroy']);
    });
    Route::controller(CategoryController::class)->group(function(){
        Route::post('category',[CategoryController::class,'store']);
        Route::put('category/{category}',[CategoryController::class,'update']);
        Route::delete('category/{category}',[CategoryController::class,'destroy']);
    });
});
