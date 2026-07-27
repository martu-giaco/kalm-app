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
use App\Models\Routine;
use App\Notifications\RoutineReminderNotification;
use App\Http\Controllers\PushSubscriptionController;
use Carbon\Carbon;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------

*/

/* web push


*/
Route::middleware(['auth'])->group(function () {
    // Ruta para guardar o actualizar el token del dispositivo del usuario
    Route::post('/push-subscriptions', function (Request $request) {
        $endpoint = $request->input('endpoint');
        $key = $request->input('keys.p256dh');
        $token = $request->input('keys.auth');

        // Validación rápida de que el navegador envió los datos correctos
        if (!$endpoint || !$key || !$token) {
            return response()->json(['success' => false, 'error' => 'Datos de suscripción incompletos.'], 422);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // updatePushSubscription es un método nativo del Trait HasPushSubscriptions
        $user->updatePushSubscription($endpoint, $key, $token);

        return response()->json(['success' => true]);
    });
});



Route::middleware('auth')->group(function () {
    Route::post('/push/subscribe', [PushSubscriptionController::class, 'store'])->name('push.subscribe');
    Route::post('/push/unsubscribe', [PushSubscriptionController::class, 'destroy'])->name('push.unsubscribe');
});

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


    // Mostrar formulario para crear review
    Route::get('/reviews/create/{product}', [ReviewController::class, 'create'])->name('reviews.create');

    // Mostrar formulario para editar review
    Route::get('/reviews/edit/{review}', [ReviewController::class, 'edit'])->name('reviews.edit');

    // Guardar nueva review
    Route::post('/reviews/store/{product}', [ReviewController::class, 'store'])->name('reviews.store');

    // Actualizar review existente
    Route::patch('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');

    // Mostrar review individual de un producto
    Route::get('/reviews/show/{product}', [ReviewController::class, 'show'])->name('reviews.show');

    // Eliminar review
    Route::delete('products/{product}/reviews/{review}', [ReviewController::class, 'destroy'])
        ->name('reviews.destroy');
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

    // Marca
    Route::get('/brands/{brand}', [BrandController::class, 'show'])->name('brands.show');

    /*
    |--------------------------------------------------------------------------
    | BLOGS
    |--------------------------------------------------------------------------
    */

    // Blog index y detalle (premium)
    Route::get('/blogs', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blogs/search', [BlogController::class, 'search'])->name('blog.search');
    Route::get('/blogs/bookmarks', [BlogController::class, 'bookmarks'])->name('blog.bookmarks');
    Route::get('/blogs/{id}', [BlogController::class, 'show'])->middleware('premium.blog')->name('blog.show');
    Route::post('/blogs/{id}/like', [BlogController::class, 'toggleLike'])->name('blog.like');
    Route::post('/blogs/{id}/bookmark', [BlogController::class, 'toggleBookmark'])->name('blog.bookmark');
    Route::get('blogs/type/{slug}', [BlogController::class, 'byType'])->name('blog.byType');
    Route::get('/blogs/tag/{slug}', [BlogController::class, 'byTag'])->name('blog.byTag');

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
        // Home admin
        Route::get('/', [HomeController::class, 'adminHome'])->name('admin.home');
        Route::get('/team', [ProfileController::class, 'equipokalm'])->name('admin.equipokalm');

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
    // Rutas para los retornos de Mercado Pago
Route::get('/premium/success', [SubscriptionController::class, 'success'])->name('subscription.success');
Route::get('/premium/error', [SubscriptionController::class, 'failure'])->name('subscription.failure');

    /*
    |--------------------------------------------------------------------------
    | ROUTINES
    |--------------------------------------------------------------------------
    */
    Route::prefix('routine')->name('routines.')->group(function () {
        Route::get('/', [RoutineController::class, 'index'])->name('index');
        Route::get('/create', [RoutineController::class, 'create'])->name('create');
        Route::post('/', [RoutineController::class, 'store'])->name('store');
        Route::post('/from-recommended/{id}', [RoutineController::class, 'storeFromRecommended'])
            ->middleware('auth')
            ->name('fromRecommended');
        Route::post('/save-recommended', [RoutineController::class, 'saveRecommendedRoutine'])
            ->middleware('auth')
            ->name('saveRecommended');

        Route::get('/{routine_id}', [RoutineController::class, 'show'])->name('show');
        Route::get('/{routine_id}/edit', [RoutineController::class, 'edit'])->name('edit');
        Route::patch('/{routine_id}', [RoutineController::class, 'update'])->name('update');
        Route::delete('/{routine}', [RoutineController::class, 'destroy'])->name('destroy');

        Route::post('/{routine_id}/add-product', [RoutineController::class, 'addProduct'])->name('addProduct');
        Route::delete('/{routine_id}/product/{product_id}', [RoutineController::class, 'removeProduct'])->name('product.remove');
        Route::post('/{routine}/complete', [RoutineController::class, 'complete'])
    ->middleware('auth')
    ->name('complete');

Route::post('/{routine}/postpone', [RoutineController::class, 'postpone'])
    ->middleware('auth')
    ->name('postpone');

Route::get('/{routine}/notify/complete', [RoutineController::class, 'notifyComplete'])
    ->middleware('signed')
    ->name('notify.complete');

Route::get('/{routine}/notify/postpone', [RoutineController::class, 'notifyPostpone'])
    ->middleware('signed')
    ->name('notify.postpone');
    });
});

// Rutas de Login con Google
Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
