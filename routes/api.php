<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\commentController;
use App\Http\Controllers\postController;
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
Route::middleware(['auth:api'])->group(function (){
    Route::resource('posts',postController::class);
    Route::post('/posts/{id}/comments',[commentController::class,'store']);
    Route::get('/posts/search',[postController::class,'search']);

});

Route::post('register', [authController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
