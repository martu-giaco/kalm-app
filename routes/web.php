<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TerminosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\TermsController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// Autenticación
Route::get('/', [AuthController::class, 'logOrReg'])->name('auth.logreg');
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');

// Alias para route('login')
Route::get('/login-alias', fn() => redirect()->route('auth.login'))->name('login');

Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'store'])->name('auth.register.store');

// Términos
Route::get('/terms', [TermsController::class, 'show'])->name('auth.terms.show');
Route::post('/terms/accept', [TermsController::class, 'accept'])->name('auth.terms.accept');

// Tests públicos
Route::prefix('tests')->name('tests.')->group(function () {
    Route::get('/', [TestController::class, 'index'])->name('index');
    Route::get('/{type}', [TestController::class, 'show'])->where('type', '[A-Za-z0-9\-_]+')->name('show');
    Route::post('/submit', [TestController::class, 'submit'])->name('submit');

    Route::get('/result/{routine}', [TestController::class, 'result'])->whereNumber('routine')->name('result');
    Route::post('/result/{routine}/save', [TestController::class, 'saveResult'])->whereNumber('routine')->middleware('auth')->name('saveResult');
    Route::get('/result/{routine}/create-routine', [TestController::class, 'createRoutineRedirect'])->whereNumber('routine')->name('createRoutine');
});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS POR AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::post('/products/{product}/review', [ReviewController::class, 'store'])->name('reviews.store');

    // Logout
    Route::post('/cerrar-sesion', [AuthController::class, 'logout'])->name('auth.logout');

    // Perfil
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::patch('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::get('/results', [ProfileController::class, 'results'])->name('results');
    });

    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Comunidad
    Route::get('/community', [CommunityController::class, 'community'])->name('community');

    /*
    |--------------------------------------------------------------------------
    | BLOGS
    |--------------------------------------------------------------------------
    */

    // Blog index y detalle (premium)
    Route::get('/blogs', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blogs/{id}', [BlogController::class, 'show'])->middleware('premium.blog')->name('blog.show');
    Route::post('/blogs/{id}/like', [BlogController::class, 'toggleLike'])->name('blog.like');

    /*
    |--------------------------------------------------------------------------
    | ADMIN BLOGS
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
        Route::get('/blogs/create', [BlogController::class, 'create'])->name('blog.create');
        Route::post('/blogs', [BlogController::class, 'store'])->name('blog.store');
        Route::get('/blogs/{id}/edit', [BlogController::class, 'edit'])->name('blog.edit');
        Route::patch('/blogs/{id}', [BlogController::class, 'update'])->name('blog.update');
        Route::delete('/blogs/{id}', [BlogController::class, 'destroy'])->name('blog.destroy');
    });

    // About, Help, Términos y Configuración
    Route::get('/about', [AboutController::class, 'about'])->name('about');
    Route::get('/help', [HelpController::class, 'help'])->name('help');
    Route::get('/terminos', [TerminosController::class, 'terminos'])->name('terminos');
    Route::get('/configuracion', [ConfigController::class, 'config'])->name('config');

    /*
    |--------------------------------------------------------------------------
    | PRODUCTOS
    |--------------------------------------------------------------------------
    */
    Route::prefix('productos')->group(function () {
        Route::get('/buscar', [ProductController::class, 'search'])->name('products.search');
        Route::get('/type/{tipo}', [ProductController::class, 'byType'])->name('products.type');
        Route::get('/categorias/{category}', [ProductController::class, 'byCategory'])->name('products.byCategory');
        Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/mis-favoritos', [ProductController::class, 'favorites'])->name('favorites');
        Route::post('/{product}/toggle-favorito', [ProductController::class, 'toggleFavorito'])->name('products.toggle-favorito');
        Route::post('/{product}/favorito', [ProductController::class, 'toggleFavorito'])->name('productos.toggleFavorito');
    });

    /*
    |--------------------------------------------------------------------------
    | SUSCRIPCIÓN
    |--------------------------------------------------------------------------
    */
    Route::get('/premium', [SubscriptionController::class, 'show'])
        ->name('subscription.show')
        ->middleware('auth');

    // Procesar pago con tarjeta (POST)
    Route::post('/premium/process', [SubscriptionController::class, 'process'])
        ->name('payment.process')
        ->middleware('auth');

    // Redirección a MercadoPago
    Route::get('/premium/mercadopago', [SubscriptionController::class, 'mercadoPago'])
        ->name('payment.mercadopago')
        ->middleware('auth');

    // Éxito / error
    Route::get('/premium/success', [SubscriptionController::class, 'success'])
        ->name('user.paysuccess')
        ->middleware('auth');

    Route::get('/premium/error', [SubscriptionController::class, 'error'])
        ->name('user.payerror')
        ->middleware('auth');

    /*
    |--------------------------------------------------------------------------
    | POSTS
    |--------------------------------------------------------------------------
    */
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::get('/{post}', [PostController::class, 'show'])->name('show');
        Route::post('/', [PostController::class, 'store'])->name('store');
        Route::post('/{post}/report', [PostController::class, 'report'])->whereNumber('post')->name('report');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');

        // Likes y guardados
        Route::post('/{post}/like', [PostController::class, 'like'])->name('like');
        Route::post('/{post}/save', [PostController::class, 'save'])->name('save');
    });

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
        Route::patch('/{routine_id}', [RoutineController::class, 'update'])->name('update');
        Route::delete('/{routine_id}/delete', [RoutineController::class, 'destroy'])->name('destroy');

        Route::post('/{routine_id}/add-product', [RoutineController::class, 'addProduct'])->name('addProduct');
        Route::delete('/{routine_id}/product/{product_id}', [RoutineController::class, 'removeProduct'])->name('product.remove');
    });
});
