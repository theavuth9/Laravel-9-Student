<?php

use App\Http\Controllers\StudentController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/students', [ StudentController::class, 'list' ]);

Route::middleware('auth:sanctum')->get('/students/{id}', [ StudentController::class, 'get' ]);

Route::middleware('auth:sanctum')->delete('/students/{id}/delete', [ StudentController::class, 'delete' ]);

Route::middleware('auth:sanctum')->post('/students/save', [ StudentController::class, 'save' ]);