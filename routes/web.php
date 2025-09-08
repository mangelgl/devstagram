<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\FollowingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->middleware('auth')->name('home');


/* Authentication Routes */
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

/* App Routes */
/** Perfil **/
Route::get('/editar-perfil', [PerfilController::class, 'index'])->middleware('auth')->name('perfil.index');
Route::post('/editar-perfil', [PerfilController::class, 'store'])->middleware('auth')->name('perfil.store');
Route::get('/search', [PerfilController::class, 'autocompletar'])->name('perfil.buscar');
Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index'); // Route model binding
Route::get('/{user:username}/followers', [FollowerController::class, 'index'])->middleware('auth')->name('followers.index');
Route::get('/{user:username}/followings', [FollowingController::class, 'index'])->middleware('auth')->name('followings.index');

/** Posts **/
Route::get('/posts/create', [PostController::class, 'create'])->middleware(['auth'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->middleware(['auth'])->name('posts.store');
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware('auth')->name('posts.destroy');
Route::post('/imagenes', [ImagenController::class, 'store'])->middleware(['auth'])->name('imagenes.store');

/** Comentarios **/
Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->middleware('auth')->name('comentarios.store');

/** Likes **/
Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->middleware('auth')->name('likes.store');
Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])->middleware('auth')->name('likes.destroy');

/** Seguidores y Siguiendo **/
Route::post('{user:username}/follow', [FollowerController::class, 'store'])->middleware('auth')->name('users.follow');
Route::delete('{user:username}/unfollow', [FollowerController::class, 'destroy'])->middleware('auth')->name('users.unfollow');
