<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

//post route

Route::get('/post',[PostController::class,'index']);

Route::get('/post/{id}',[PostController::class,'show']);

Route::post('/post/create',[PostController::class,'create']);

Route::put('/post/{id}',[PostController::class,'edit']);

Route::delete('/post/{id}',[PostController::class,'destroy']);

//end post route


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

});
