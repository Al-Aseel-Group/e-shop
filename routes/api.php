<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\User\AuthController;
use App\Http\Middleware\EmailMiddleware;
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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function () {

    Route::post('login', [AuthController::class,'login']);
    // Route::post('refresh', 'AuthController@refresh');
    Route::get('me', [AuthController::class,'me']);

});


Route::prefix('admin')->group(function(){

    Route::post('login', [AdminAuthController::class,'login']);
    // Route::post('refresh', 'AuthController@refresh');
    Route::get('me', [AdminAuthController::class,'me']);
    Route::apiResource('category',CategoryController::class);

});