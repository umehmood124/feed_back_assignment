<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login_success', [UserController::class, 'login_success']);
Route::post('/register_user', [UserController::class, 'register_user']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('get_catagories', [CategoryController::class, 'get_catagories']);
    Route::post('submit_feedback', [FeedbackController::class, 'submit_feedback']);
    Route::get('get_feedback', [FeedbackController::class, 'get_feedback']);
    Route::post('insert_comment', [CommentController::class, 'insert_comment']);
    Route::get('/get_users', [UserController::class, 'get_users']);
    Route::post('logout', [UserController::class, 'logout']);
});




