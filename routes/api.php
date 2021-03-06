<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource("tags" , \App\Http\Controllers\api\TagController::class);
Route::apiResource("articles" , \App\Http\Controllers\api\ArticleController::class);
Route::apiResource("products" , \App\Http\Controllers\api\ProductController::class);

Route::post("search_tag" , [\App\Http\Controllers\api\TagController::class , "search_tags"]);
