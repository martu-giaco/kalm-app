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
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;

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
    Route::get('/intro', function () {
        return view('tests.intro');
    })->name('intro');
    Route::get('/', [TestController::class, 'index'])->name('index');
    Route::post('/submit', [TestController::class, 'submit'])->name('submit');

    // Rutas de resultados (sin parámetro de routine)
    Route::get('/result', [TestController::class, 'result'])->name('result');
    Route::post('/result/save', [TestController::class, 'saveResult'])->middleware('auth')->name('saveResult');
    Route::get('/result/create-routine', [TestController::class, 'createRoutineRedirect'])->middleware('auth')->name('createRoutine');

    // Mostrar test por tipo (debe estar al final para no capturar las otras rutas)
    Route::get('/{type}', [TestController::class, 'show'])->where('type', '[A-Za-z0-9\-_]+')->name('show');
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
        Route::get('/password', [ProfileController::class, 'password'])->name('password');
        Route::patch('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::get('/results', [ProfileController::class, 'results'])->name('results');
        Route::delete('/delete', [ProfileController::class, 'destroy'])->name('user.destroy');
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
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
        // Home admin
        Route::get('/', [HomeController::class, 'adminHome'])->name('admin.home');

        //Usuarios CRUD
        Route::get('/users', [ProfileController::class, 'index'])->name('admin.users.index');
        Route::get('/users/{user}', [ProfileController::class, 'view'])->name('admin.users.view');
        Route::get('/users/{id}/edit', [ProfileController::class, 'adminEdit'])->name('admin.users.edit');
        Route::patch('/users/{id}', [ProfileController::class, 'adminUpdate'])->name('admin.users.update');
        Route::delete('/users/{id}', [ProfileController::class, 'adminDestroy'])->name('admin.users.destroy');

        //Products CRUD
        Route::get('/products', [ProductController::class, 'adminIndex'])->name('admin.products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products/{product}', [ProductController::class, 'view'])->name('admin.products.view');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::patch('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

        //Marcas CRUD
        Route::get('/brands', [BrandController::class, 'index'])->name('admin.brands.index');
        Route::get('/brands/create', [BrandController::class, 'create'])->name('admin.brands.create');
        Route::post('/brands', [BrandController::class, 'store'])->name('admin.brands.store');
        Route::get('/brands/{brand}', [BrandController::class, 'view'])->name('admin.brands.view');
        Route::get('/brands/{brand}/edit', [BrandController::class, 'adminEdit'])->name('admin.brands.edit');
        Route::patch('/brands/{brand}', [BrandController::class, 'update'])->name('admin.brands.update');
        Route::delete('/brands/{brand}', [BrandController::class, 'adminDestroy'])->name('admin.brands.destroy');

        //Blogs CRUD
        Route::get('/blogs', [BlogController::class, 'adminIndex'])->name('admin.blog.index');
        Route::get('/blogs/create', [BlogController::class, 'create'])->name('admin.blog.create');
        Route::get('/blogs/{blog}', [BlogController::class, 'view'])->name('admin.blog.view');
        Route::post('/blogs', [BlogController::class, 'store'])->name('admin.blog.store');
        Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('admin.blog.edit');
        Route::patch('/blogs/{blog}', [BlogController::class, 'update'])->name('admin.blog.update');
        Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('admin.blog.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | EXTRAS
    |--------------------------------------------------------------------------
    */
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
        Route::get('/mis-favoritos', [ProductController::class, 'favorites'])->name('favorites');
        Route::get('/type/{tipo}', [ProductController::class, 'byType'])->name('products.type');
        Route::get('/categorias/{category}', [ProductController::class, 'byCategory'])->name('products.byCategory');
        Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
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

    // Checkout (confirmación antes de pago)
    Route::get('/premium/checkout', [SubscriptionController::class, 'checkout'])
        ->name('subscription.checkout')
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
        Route::post('/from-recommended/{id}', [RoutineController::class, 'storeFromRecommended'])
            ->middleware('auth')
            ->name('fromRecommended');

        Route::get('/{routine_id}', [RoutineController::class, 'show'])->name('show');
        Route::get('/{routine_id}/edit', [RoutineController::class, 'edit'])->name('edit');
        Route::patch('/{routine_id}', [RoutineController::class, 'update'])->name('update');
        Route::delete('/{routine_id}/delete', [RoutineController::class, 'destroy'])->name('destroy');

        Route::post('/{routine_id}/add-product', [RoutineController::class, 'addProduct'])->name('addProduct');
        Route::delete('/{routine_id}/product/{product_id}', [RoutineController::class, 'removeProduct'])->name('product.remove');
    });
});
