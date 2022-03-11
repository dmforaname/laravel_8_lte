<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users-check', [Api\UserController::class,'userCheck']);


Route::middleware(['auth:sanctum','abilities:admin'])->group(function () {
    
    Route::prefix('users')->name('UsersApi.')->group(function () {
    
        Route::get('/role', [Api\UserController::class,'getListRoles'])->name('listRoles');
        Route::resource('', Api\UserController::class)->only(['index','show','update','store'])
            ->parameters(['' => 'uuid']);
    });

    Route::post('/logout', [Api\UserController::class,'logout']);
});