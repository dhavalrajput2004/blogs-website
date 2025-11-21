<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
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

// Route::resource('posts', PostController::class);
Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class, 'logOut'])->name('logout');
    
    Route::get('posts', [PostController::class, 'index'])->name('posts.index');
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('posts/{post}', [PostController::class, 'show'])->name('post.show');

    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('post.destroy');

    // Route::resource('comments', CommentController::class);

    Route::get('posts/{post}/comments', [CommentController::class, 'create'])->name('comments.create');
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::get('posts/{post}/comments/{comment}', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('posts/{post}/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');

    Route::delete('posts/{post}/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});


Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('login-user',[AuthController::class, 'postLogin'])->name('login.post');
Route::post('register-user',[AuthController::class, 'postRegister'])->name('register.post');