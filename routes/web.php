<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\Auth\TermsController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

// Auth (login/logout/register)
Route::get('/login-register', [AuthController::class, 'logOrReg'])->name('auth.logreg');
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');

Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'store'])->name('auth.register.store');

// Términos
Route::get('/terms', [TermsController::class, 'show'])->name('auth.terms.show');
Route::post('/terms/accept', [TermsController::class, 'accept'])->name('auth.terms.accept');

/*
|--------------------------------------------------------------------------
| Rutas protegidas por Auth
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/cerrar-sesion', [AuthController::class, 'logout'])->name('auth.logout');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Home
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Búsqueda
    Route::get('/search', [SearchController::class, 'search'])->name('search');

    // Comunidad
    Route::get('/community', [CommunityController::class, 'community'])->name('community');

    // Blog
    Route::get('/blog', [BlogController::class, 'blog'])->name('blog');

    // Productos
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/productos/buscar', [ProductController::class, 'search'])->name('products.search');
    Route::get('/products/type/{tipo}', [ProductController::class, 'byType'])->name('products.type');
    Route::get('/products/category/{slug}', [ProductController::class, 'byCategory'])->name('products.byCategory');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    // Favoritos
    Route::get('/mis-favoritos', [ProductController::class, 'favorites'])->name('favorites');
    Route::post('/favorito/toggle/{product}', [ProductController::class, 'toggleFavorito'])->name('products.toggle-favorito');
    Route::post('/productos/{product}/favorito', [ProductController::class, 'toggleFavorito'])->name('productos.toggleFavorito');

    // Suscripción
    Route::get('/premium', [SubscriptionController::class, 'show'])->name('subscription');
    Route::post('/premium/process', [SubscriptionController::class, 'process'])->name('subscription.process');

    // Admin
    Route::middleware([AdminMiddleware::class])->prefix('admin')->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // CRUD blogs
        Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
        Route::post('/blog', [PostController::class, 'store'])->name('blog.store');
        Route::get('/blog/{blog_id}', [BlogController::class, 'edit'])->name('blog.edit');
        Route::delete('/blog/{blog_id}', [BlogController::class, 'destroy'])->name('blog.destroy');
    });

    // Posts
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{post}/report', [PostController::class, 'report'])->name('posts.report')->whereNumber('post');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Likes y guardados
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::post('/posts/{post}/save', [PostController::class, 'save'])->name('posts.save');

    // Routines
    Route::get('/routine', [RoutineController::class, 'index'])->name('routines.index');
    Route::get('/routine/create', [RoutineController::class, 'create'])->name('routines.create');
    Route::post('/routine', [RoutineController::class, 'store'])->name('routines.store');
    Route::get('/routine/{routine_id}', [RoutineController::class, 'view'])->name('routines.view');
    Route::get('/routine/{routine_id}/edit', [RoutineController::class, 'edit'])->name('routines.edit');
    Route::get('/routine/{routine_id}/delete', [RoutineController::class, 'destroy'])->name('routines.destroy');
    Route::post('/routine/add-product', [RoutineController::class, 'addProduct'])->middleware('auth')->name('routine.addProduct');

    /*
    |--------------------------------------------------------------------------
    | Tests
    |--------------------------------------------------------------------------
    */

    // Página para elegir test
    Route::get('/tests', [TestController::class, 'index'])->name('tests.index');

    // Mostrar test según tipo (piel, cabello, etc.)
    Route::get('/tests/{type}', [TestController::class, 'show'])->name('tests.show');

    // Guardar respuestas del test
    Route::post('/tests/submit', [TestController::class, 'submit'])->name('tests.submit');
    Route::get('/tests/result/{routine}', [TestController::class, 'result'])->name('tests.result');



});
