<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemTaskController;
use App\Http\Controllers\TaskController;
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
Route::prefix('/v1')->group(function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('auth:api')->group(function() {
        Route::apiResource('task', TaskController::class);
        Route::get('detail-sub-task/{idParent}', [ItemTaskController::class, 'detailSubTask']);
        Route::put('item-task-status/{itemTask}', [ItemTaskController::class, 'updateStatus']);
        Route::apiResource('item-task', ItemTaskController::class);
        
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });

});

