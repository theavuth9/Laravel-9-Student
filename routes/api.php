<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

Route::post('/login', function (Request $request) {

    $data = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response([
            'status' => 'fail',
            'message' => 'These credentials do not match our records.',
            'data' => ''
        ], 404);
    }

    $token = $user->createToken('my-app-token')->plainTextToken;

    $response = [
        'status' => 'success',
        'message' => 'login successfully',
        'data' => $user,
        'token' => $token
    ];

    return response($response, 201);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/students', [ StudentController::class, 'list' ]);

Route::middleware('auth:sanctum')->get('/students/{id}', [ StudentController::class, 'get' ]);

Route::middleware('auth:sanctum')->delete('/students/{id}/delete', [ StudentController::class, 'delete' ]);

Route::middleware('auth:sanctum')->post('/students/save', [ StudentController::class, 'save' ]);