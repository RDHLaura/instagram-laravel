<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ImageController;
use \App\Http\Controllers\LikeController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\CommentController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('images_user', [ImageController::class, 'images_user'])->name('images_user');

Route::get('image_detail', [ImageController::class, 'image_detail'])->name('image_detail');

Route::get('images_fav', [ImageController::class, 'images_fav'])->name('images_fav');

Route::resource("images", \App\Http\Controllers\ImageController::class)
->middleware("auth");

Route::resource("users", \App\Http\Controllers\UserController::class)
->middleware("auth");


Route::resource("comment", \App\Http\Controllers\CommentController::class)
->middleware("auth");

Route::resource("likes", \App\Http\Controllers\LikeController::class)
->middleware("auth");

require __DIR__.'/auth.php';
