<?php

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
    'prefix' => config('passport.path', 'oauth'),
    'middleware' => 'auth:api',
], function () {
    Route::get('/me', function () {
        return response([
            'data' => auth()->user(),
        ]);
    });
    Route::post('/token/destroy', function () {
        auth()->user()?->token()?->revoke();
        return response([]);
    });
});
