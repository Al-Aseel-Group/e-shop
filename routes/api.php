<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Upload;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\EmailMiddleware;
use App\Http\Middleware\Test;
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
Route::post('auth/login', [AuthController::class,'login'])->middleware('api');
Route::group([

    'middleware' => ['api',AuthMiddleware::class],
    'prefix' => 'auth'

], function () {


    // Route::post('refresh', 'AuthController@refresh');
    Route::get('me', [AuthController::class,'me']);

    Route::apiResource('cart',CartController::class)->except('show');
    Route::put('cart/{product}/remove',[CartController::class,'remove']);
    Route::apiResource('order',OrderController::class)->except(['update','destroy']);

});

Route::apiResource('product',UserProductController::class)->only([
    'index',
    'show'
]);

Route::prefix('admin')->group(function(){

    Route::post('login', [AdminAuthController::class,'login']);
    // Route::post('refresh', 'AuthController@refresh');
    Route::get('me', [AdminAuthController::class,'me']);
    Route::apiResource('category',CategoryController::class);
    Route::get('category/{category}/product',[ProductController::class,'index']);
    Route::apiResource('product',ProductController::class)->except('index');
    Route::post('upload',Upload::class);

});
