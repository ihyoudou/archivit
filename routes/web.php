<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PostsController::class, 'getData']);
Route::get('/r/{subreddit}', [PostsController::class, 'getSubreddit']);
Route::get('/r/{subreddit}/comments/{rid}', [PostsController::class, 'getPost']);

// User
Route::get('/user/{username}', [AuthorController::class, 'getUser']);
