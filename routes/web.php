<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PushSubscriptionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TerminosController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Auth\TermsController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS Y AUTENTICACIÓN INICIAL
|--------------------------------------------------------------------------
*/

// Vistas de Autenticación tradicional
Route::get('/', [AuthController::class, 'logOrReg'])->name('auth.logreg');
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');
Route::get('/login-alias', fn() => redirect()->route('auth.login'))->name('login');

Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'store'])->name('auth.register.store');

// Autenticación Social (Google OAuth - Login / Registro)
Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Términos y Condiciones públicos
Route::get('/terms', [TermsController::class, 'show'])->name('auth.terms.show');
Route::post('/terms/accept', [TermsController::class, 'accept'])->name('auth.terms.accept');

// Tests interactivos públicos
Route::prefix('tests')->name('tests.')->group(function () {
    Route::get('/intro', fn() => view('tests.intro'))->name('intro');
    Route::get('/', [TestController::class, 'index'])->name('index');
    Route::post('/submit', [TestController::class, 'submit'])->name('submit');
    Route::get('/result', [TestController::class, 'result'])->name('result');

    // Acciones de test que requieren o pueden usar Auth
    Route::post('/result/save', [TestController::class, 'saveResult'])->middleware('auth')->name('saveResult');
    Route::get('/result/create-routine', [TestController::class, 'createRoutineRedirect'])->middleware('auth')->name('createRoutine');

    // Vista de tipo de test (Expresión regular para evitar capturar subrutas)
    Route::get('/{type}', [TestController::class, 'show'])->where('type', '[A-Za-z0-9\-_]+')->name('show');
});


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (REQUIEREN AUTENTICACIÓN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Cerrar Sesión
    Route::post('/cerrar-sesion', [AuthController::class, 'logout'])->name('auth.logout');

    // Dashboard / Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    /*
    |--------------------------------------------------------------------------
    | PERFIL DE USUARIO
    |--------------------------------------------------------------------------
    */
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::get('/password', [ProfileController::class, 'password'])->name('password');
        Route::patch('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::get('/results', [ProfileController::class, 'results'])->name('results');
        Route::delete('/delete', [ProfileController::class, 'destroy'])->name('user.destroy');
    });
    Route::get('/avatar/{filename}', [ProfileController::class, 'getAvatar'])->name('avatar.file');

    /*
    |--------------------------------------------------------------------------
    | RUTINAS (ROUTINES)
    |--------------------------------------------------------------------------
    */
    Route::prefix('routine')->name('routines.')->group(function () {
        Route::get('/', [RoutineController::class, 'index'])->name('index');
        Route::get('/create', [RoutineController::class, 'create'])->name('create');
        Route::post('/', [RoutineController::class, 'store'])->name('store');
        
        // Rutinas recomendadas
        Route::post('/from-recommended/{id}', [RoutineController::class, 'storeFromRecommended'])->name('fromRecommended');
        Route::post('/save-recommended', [RoutineController::class, 'saveRecommendedRoutine'])->name('saveRecommended');

        // CRUD individual
        Route::get('/{routine_id}', [RoutineController::class, 'show'])->name('show');
        Route::get('/{routine_id}/edit', [RoutineController::class, 'edit'])->name('edit');
        Route::patch('/{routine_id}', [RoutineController::class, 'update'])->name('update');
        Route::delete('/{routine}', [RoutineController::class, 'destroy'])->name('destroy');

        // Gestión de productos en rutinas
        Route::post('/{routine_id}/add-product', [RoutineController::class, 'addProduct'])->name('addProduct');
        Route::delete('/{routine_id}/product/{product_id}', [RoutineController::class, 'removeProduct'])->name('product.remove');

        // Acciones de rutina
        Route::post('/{routine}/complete', [RoutineController::class, 'complete'])->name('complete');
        Route::post('/{routine}/postpone', [RoutineController::class, 'postpone'])->name('postpone');

        // Notificaciones firmadas
        Route::get('/{routine}/notify/complete', [RoutineController::class, 'notifyComplete'])->middleware('signed')->name('notify.complete');
        Route::get('/{routine}/notify/postpone', [RoutineController::class, 'notifyPostpone'])->middleware('signed')->name('notify.postpone');
    });

    /*
    |--------------------------------------------------------------------------
    | VINCULACIÓN CON GOOGLE CALENDAR
    |--------------------------------------------------------------------------
    */
    Route::prefix('google-calendar')->name('google.calendar.')->group(function () {
        Route::get('/connect', [GoogleCalendarController::class, 'connect'])->name('connect');
        Route::get('/callback', [GoogleCalendarController::class, 'callback'])->name('callback');
        Route::post('/sync-routine/{routine}', [GoogleCalendarController::class, 'syncRoutine'])->name('syncRoutine');
        Route::delete('/disconnect', [GoogleCalendarController::class, 'disconnect'])->name('disconnect');
    });

    /*
    |--------------------------------------------------------------------------
    | PRODUCTOS Y FAVORITOS
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
    | RESEÑAS Y REVIEWS
    |--------------------------------------------------------------------------
    */
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/create/{product}', [ReviewController::class, 'create'])->name('create');
        Route::get('/edit/{review}', [ReviewController::class, 'edit'])->name('edit');
        Route::post('/store/{product}', [ReviewController::class, 'store'])->name('store');
        Route::patch('/{review}', [ReviewController::class, 'update'])->name('update');
        Route::get('/show/{product}', [ReviewController::class, 'show'])->name('show');
        Route::get('/reviews/image/{filename}', [ReviewController::class, 'getImage'])->name('reviews.image');
    });
    Route::delete('products/{product}/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    /*
    |--------------------------------------------------------------------------
    | BLOGS (Sección Protegida)
    |--------------------------------------------------------------------------
    */
    Route::prefix('blogs')->name('blog.')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('/search', [BlogController::class, 'search'])->name('search');
        Route::get('/bookmarks', [BlogController::class, 'bookmarks'])->name('bookmarks');
        Route::get('/type/{slug}', [BlogController::class, 'byType'])->name('byType');
        Route::get('/tag/{slug}', [BlogController::class, 'byTag'])->name('byTag');
        
        // Detalle de blog protegido por middleware premium
        Route::get('/{id}', [BlogController::class, 'show'])->middleware('premium.blog')->name('show');
        Route::post('/{id}/like', [BlogController::class, 'toggleLike'])->name('like');
        Route::post('/{id}/bookmark', [BlogController::class, 'toggleBookmark'])->name('bookmark');
    });

    /*
    |--------------------------------------------------------------------------
    | SUSCRIPCIONES Y PAGOS (MERCADOPAGO)
    |--------------------------------------------------------------------------
    */
    Route::prefix('premium')->group(function () {
        Route::get('/', [SubscriptionController::class, 'show'])->name('subscription.show');
        Route::get('/checkout', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');
        Route::post('/process', [SubscriptionController::class, 'process'])->name('payment.process');
        Route::get('/mercadopago', [SubscriptionController::class, 'mercadoPago'])->name('payment.mercadopago');
        Route::get('/success', [SubscriptionController::class, 'success'])->name('subscription.success');
        Route::get('/error', [SubscriptionController::class, 'failure'])->name('subscription.failure');
        Route::post('/webhook', [SubscriptionController::class, 'webhook'])->name('subscription.webhook');
    });

    /*
    |--------------------------------------------------------------------------
    | NOTIFICACIONES WEB PUSH
    |--------------------------------------------------------------------------
    */
    Route::prefix('push')->name('push.')->group(function () {
        Route::post('/subscribe', [PushSubscriptionController::class, 'store'])->name('subscribe');
        Route::post('/unsubscribe', [PushSubscriptionController::class, 'destroy'])->name('unsubscribe');
    });
    
    // Endpoint para actualización rápida de suscripción Push
    Route::post('/push-subscriptions', function (Request $request) {
        $endpoint = $request->input('endpoint');
        $key = $request->input('keys.p256dh');
        $token = $request->input('keys.auth');

        if (!$endpoint || !$key || !$token) {
            return response()->json(['success' => false, 'error' => 'Datos de suscripción incompletos.'], 422);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->updatePushSubscription($endpoint, $key, $token);

        return response()->json(['success' => true]);
    });

    /*
    |--------------------------------------------------------------------------
    | MARCAS Y SECCIONES INFORMATIVAS
    |--------------------------------------------------------------------------
    */
    Route::get('/brands/{brand}', [BrandController::class, 'show'])->name('brands.show');
    Route::get('/about', [AboutController::class, 'about'])->name('about');
    Route::get('/help', [HelpController::class, 'help'])->name('help');
    Route::get('/terminos', [TerminosController::class, 'terminos'])->name('terminos');
    Route::get('/configuracion', [ConfigController::class, 'config'])->name('config');

    /*
    |--------------------------------------------------------------------------
    | PANEL DE ADMINISTRACIÓN (ADMIN)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard Admin
        Route::get('/', [HomeController::class, 'adminHome'])->name('home');
        Route::get('/team', [ProfileController::class, 'equipokalm'])->name('equipokalm');

        // Usuarios CRUD
        Route::get('/users', [ProfileController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [ProfileController::class, 'view'])->name('users.view');
        Route::get('/users/{id}/edit', [ProfileController::class, 'adminEdit'])->name('users.edit');
        Route::patch('/users/{id}', [ProfileController::class, 'adminUpdate'])->name('users.update');
        Route::delete('/users/{id}', [ProfileController::class, 'adminDestroy'])->name('users.destroy');

        // Productos CRUD
        Route::get('/products', [ProductController::class, 'adminIndex'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}', [ProductController::class, 'view'])->name('products.view');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Marcas CRUD
        Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
        Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
        Route::get('/brands/{brand}', [BrandController::class, 'view'])->name('brands.view');
        Route::get('/brands/{brand}/edit', [BrandController::class, 'adminEdit'])->name('brands.edit');
        Route::patch('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('/brands/{brand}', [BrandController::class, 'adminDestroy'])->name('brands.destroy');

        // Blogs CRUD
        Route::get('/blogs', [BlogController::class, 'adminIndex'])->name('blog.index');
        Route::get('/blogs/create', [BlogController::class, 'create'])->name('blog.create');
        Route::get('/blogs/{blog}', [BlogController::class, 'view'])->name('blog.view');
        Route::post('/blogs', [BlogController::class, 'store'])->name('blog.store');
        Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blog.edit');
        Route::patch('/blogs/{blog}', [BlogController::class, 'update'])->name('blog.update');
        Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blog.destroy');
        
        //Reviews CRUD
        Route::prefix('reviews')->name('reviews.')->group(function () {
            Route::get('/', [ReviewController::class, 'adminIndex'])->name('index');
            Route::get('/{review}', [ReviewController::class, 'adminView'])->name('view');
            Route::get('/{review}/edit', [ReviewController::class, 'adminEdit'])->name('edit');
            Route::patch('/{review}', [ReviewController::class, 'adminUpdate'])->name('update');
            Route::delete('/{review}', [ReviewController::class, 'adminDestroy'])->name('destroy');
        });
    });

});