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

// Auth
Route::get('/', [AuthController::class, 'logOrReg'])->name('auth.logreg');
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');

Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'store'])->name('auth.register.store');

// Términos
Route::get('/terms', [TermsController::class, 'show'])->name('auth.terms.show');
Route::post('/terms/accept', [TermsController::class, 'accept'])->name('auth.terms.accept');

// Tests públicos
Route::prefix('tests')->name('tests.')->group(function () {
    Route::get('/', [TestController::class, 'index'])->name('index');
    Route::get('/{type}', [TestController::class, 'show'])
        ->where('type', '[A-Za-z0-9\-_]+')
        ->name('show');
    Route::post('/submit', [TestController::class, 'submit'])->name('submit');

    Route::get('/result/{routine}', [TestController::class, 'result'])
        ->whereNumber('routine')
        ->name('result');
    Route::post('/result/{routine}/save', [TestController::class, 'saveResult'])
        ->whereNumber('routine')
        ->middleware('auth')
        ->name('saveResult');
    Route::get('/result/{routine}/create-routine', [TestController::class, 'createRoutineRedirect'])
        ->whereNumber('routine')
        ->name('createRoutine');
});

/*
|--------------------------------------------------------------------------
| Rutas protegidas por auth
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/cerrar-sesion', [AuthController::class, 'logout'])->name('auth.logout');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/results', [ProfileController::class, 'results'])->name('profile.results');

    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

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
    Route::get('/categorias/{category}', [ProductController::class, 'byCategory'])->name('products.byCategory');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    // Favoritos
    Route::get('/mis-favoritos', [ProductController::class, 'favorites'])->name('favorites');
    Route::post('/favorito/toggle/{product}', [ProductController::class, 'toggleFavorito'])->name('products.toggle-favorito');
    Route::post('/products/{product}/favorito', [ProductController::class, 'toggleFavorito'])->name('productos.toggleFavorito');

    // Suscripción
    Route::get('/premium', [SubscriptionController::class, 'show'])->name('subscription');
    Route::post('/premium/process', [SubscriptionController::class, 'process'])->name('subscription.process');

    // Admin
    Route::middleware([AdminMiddleware::class])->prefix('admin')->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // CRUD Blogs
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
    Route::post('/posts/{post}/report', [PostController::class, 'report'])->whereNumber('post')->name('posts.report');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Likes y guardados
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::post('/posts/{post}/save', [PostController::class, 'save'])->name('posts.save');

    /*
    |--------------------------------------------------------------------------
    | RUTINES
    |--------------------------------------------------------------------------
    */
    Route::prefix('routine')->name('routines.')->group(function () {
        Route::get('/', [RoutineController::class, 'index'])->name('index');
        Route::get('/create', [RoutineController::class, 'create'])->name('create');
        Route::post('/', [RoutineController::class, 'store'])->name('store');
        Route::get('/{routine_id}', [RoutineController::class, 'show'])->name('show');
        Route::get('/{routine_id}/edit', [RoutineController::class, 'edit'])->name('edit');
        Route::patch('/{routine_id}', [RoutineController::class, 'update'])->name('update'); // <-- PATCH
        Route::delete('/{routine}/delete', [RoutineController::class, 'destroy'])->name('destroy');

        // Agregar producto a rutina desde la vista del producto
        Route::post('/{routine}/add-product', [RoutineController::class, 'addProduct'])->name('addProduct');

        // Eliminar producto de la rutina
        Route::delete('/{routine}/product/{product}', [RoutineController::class, 'removeProduct'])
            ->name('product.remove');

    });

});
