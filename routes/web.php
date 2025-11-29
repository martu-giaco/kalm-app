<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\BlogController;

// vistas
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/community', [CommunityController::class, 'community'])->name('community');
Route::get('/blog', [BlogController::class, 'blog'])->name('blog');
