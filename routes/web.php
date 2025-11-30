<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;

// Auth (login/logout)
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');
Route::post('/cerrar-sesion', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'store'])->name('auth.register.store');


// Vistas User
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/community', [CommunityController::class, 'community'])->name('community');
Route::get('/blog', [BlogController::class, 'blog'])->name('blog');

// Vistas Admin
Route::get('/view-users', [AuthController::class, 'admin.users.index'])->middleware(\App\Http\Middleware\AdminMiddleware::class)->name('admin.users.index')->middleware('auth');
Route::get('/view-users/{user}', [AuthController::class, 'admin.users.view'])->middleware(\App\Http\Middleware\AdminMiddleware::class)->name('admin.users.view')->whereNumber('user')->middleware('auth');
