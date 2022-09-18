<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\Auth\LoginController;
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

Route::get('/search', [PostsController::class, 'search']);

// User
Route::get('/user/{username}', [AuthorController::class, 'getUser']);


// Admin panel
Route::prefix('/admin')->group(function(){
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
// Admin panel authenticated
Route::middleware('auth')->group(function(){
    Route::prefix('/admin')->group(function(){
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/list', [AdminController::class, 'list'])->name('admin.subredditlist');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});



