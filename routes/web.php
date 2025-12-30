<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\TagController;

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
   // Route::get('blogs/search', [BlogController::class, 'search'])->name('blogs.search');
    Route::get('logout', [AuthController::class, 'logOut'])->name('logout');

    Route::get('manage/categories', [CategoryController::class, 'index'])->name('category.index');

    Route::post('categories', [CategoryController::class, 'store'])->name('category.store');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

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
    Route::post('login-user',[AuthController::class, 'postLogin'])->name('login.post');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register-user',[AuthController::class, 'postRegister'])->name('register.post');

    Route::get('blogs', [BlogController::class, 'index'])->name('blogs.index')->middleware();
    Route::get('blogs/{post}', [BlogController::class, 'show'])->name('blog.show');

    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware(['auth', 'admin', 'last_activity']);

    Route::get('/send-email', [MailController::class, 'sendEmail']);
    Route::get('/test', [MailController::class, 'sendEmail']);

    Route::get('categories/{category_name}', [CategoryController::class, 'show'])->name('category.show');
    Route::get('tags/{tag_name}', [TagController::class, 'show'])->name('tag.show');

    Route::post('blogs/{post}/updateLikes', [LikeController::class, 'updateLikes'])->name('post.likes');
    Route::post('blogs/{comment}/updateCommentLikes', [LikeController::class, 'updateCommentLikes'])->name('comment.likes');

    Route::get('getsuggestions', [BlogController::class, 'getSuggestions'])->name('blogs.suggestions');

    Route::get('authors/{author}', [BlogController::class, 'listByAuthor'])->name('blog.author');