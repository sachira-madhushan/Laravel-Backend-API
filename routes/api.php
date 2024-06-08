<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// PostController::class,'newpost'
Route::post('/post/create',function(Request $req){
    return PostController::create($req);
});
