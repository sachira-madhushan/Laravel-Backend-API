<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;


Route::get('/post',[PostController::class,'index']);
Route::get('/post/{id}',[PostController::class,'show']);

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', [AuthController::class,'login']);
    Route::post('register', [AuthController::class,'register']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

});

Route::group([
    'middleware'=>'api'
],function ($router){
    Route::post('/post/create',[PostController::class,'create']);
    Route::put('/post/{id}',[PostController::class,'edit']);
    Route::delete('/post/{id}',[PostController::class,'destroy']);
});

