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
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PostController;


/*
| Rutas de Autenticación y Perfiles
*/

// Auth (login/logout/register)
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');

Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'store'])->name('auth.register.store');

Route::post('/cerrar-sesion', [AuthController::class, 'logout'])
    ->middleware('auth') // Solo usuarios logueados pueden cerrar sesión
    ->name('auth.logout');



use App\Http\Middleware\AdminMiddleware;

Route::prefix('admin')->middleware([AdminMiddleware::class])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}', [UserController::class, 'view'])->name('admin.users.view')->whereNumber('user');
});



// Perfil (protegido)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    // Usamos PATCH/PUT para actualizaciones de recursos si es posible
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});



// Home - Usa 'index' para el controlador
Route::get('/', [HomeController::class, 'index'])->name('home');

// Búsqueda
Route::get('/search', [SearchController::class, 'search'])->name('search');

// Comunidad
Route::get('/community', [CommunityController::class, 'community'])->name('community');

// Blog
Route::get('/blog', [BlogController::class, 'blog'])->name('blog');

// Productos


Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');
Route::get('/productos/buscar', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');


Route::get('/products/type/{tipo}', [ProductController::class, 'byType'])
    ->name('products.type');
Route::post('/productos/{product}/favorito', [ProductController::class, 'toggleFavorito'])->name('productos.toggleFavorito');


Route::get('/products/category/{slug}', [ProductController::class, 'byCategory'])
    ->name('products.byCategory');
Route::middleware('auth')->group(function () {
    Route::get('/mis-favoritos', [ProductController::class, 'favorites'])->name('favorites');
    Route::post('/favorito/toggle/{product}', [ProductController::class, 'toggleFavorito'])
        ->name('products.toggle-favorito');
});

// RUTA DE SUSCRIPCIÓN
Route::get('/premium', [SubscriptionController::class, 'show'])->name('subscription');
Route::post('/premium/process', [SubscriptionController::class, 'process'])->name('subscription.process')->middleware('auth');


/*
| Rutas de Administración (Protegidas)
*/
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->group(function () {

    // Ver y listar todos los usuarios
    // Antes: Route::get('/view-users', [AuthController::class, 'admin.users.index']) <- ¡Error de sintaxis!
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');

    // Ver el detalle de un usuario específico
    // Antes: Route::get('/view-users/{user}', [AuthController::class, 'admin.users.view']) <- ¡Error de sintaxis!
    Route::get('/users/{user}', [UserController::class, 'view'])->name('admin.users.view')->whereNumber('user');

    // Aquí irían otras rutas de administración (e.g., /admin/products, /admin/stats)

    // CRUD blogs
    Route::get('/admin/blog', [BlogController::class, 'blog'])->name('blog.index');
    Route::get('/admin/blog', [BlogController::class, 'blog'])->name('blog.view');
    Route::get('/admin/blog/create', [BlogController::class, 'blog'])->name('blog.create');
    Route::get('/admin/blog/{blog_id}', [BlogController::class, 'blog'])->name('blog.edit');
    Route::get('/admin/blog', [BlogController::class, 'blog'])->name('blog.destroy');
});

Route::middleware('auth')->group(function () {
    // Ver detalle de un post
// Detalle de un post
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{post}/report', [PostController::class, 'report'])
        ->name('posts.report')
        ->whereNumber('post');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Likes y guardados
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::post('/posts/{post}/save', [PostController::class, 'save'])->name('posts.save');
});

// Detalle del post (no requiere auth para ver)
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/community', [CommunityController::class, 'community'])->name('community');
Route::get('/community', [PostController::class, 'community'])->name('community');
