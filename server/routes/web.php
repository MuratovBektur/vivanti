<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;

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

$post_label = 'post';

Route::name($post_label)->prefix($post_label)->group(function () {
    Route::get('all', [PostController::class, 'getAll']);
    Route::get('{post_id}/{user_id}', [PostController::class, 'getId']);

});

Route::post('comment/add', [CommentController::class, 'add']);
Route::post('comment/addLike', [CommentController::class, 'addLike']);
Route::post('comment/removeLike', [CommentController::class, 'removeLike']);