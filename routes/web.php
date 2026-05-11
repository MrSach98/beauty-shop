<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\ChildSubcategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// ── Auth Routes (Guest only) ──────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',           [LoginController::class, 'showForm'])->name('login');
    Route::post('/login',          [LoginController::class, 'login'])->name('login.submit');
    Route::get('/register',        [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register',       [RegisterController::class, 'register'])->name('register.submit');
});

// ── Logout ────────────────────────────────────────────
Route::post('/logout', [LogoutController::class, 'logout'])
     ->middleware('auth')
     ->name('logout');



// ── Admin Routes ──────────────────────────────────────
Route::prefix('admin')
     ->middleware(['auth', 'isAdmin', 'checkActive'])
     ->name('admin.')
     ->group(function () {
         Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
         // ── Categories ──────────────────────────────
        Route::get('/categories',         [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories',        [CategoryController::class, 'store'])->name('categories.store');
        Route::post('/categories/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle');
         Route::delete('/categories/remove-image/{id}',  [CategoryController::class, 'removeImage'])->name('categories.remove-image');
        Route::post('/categories/{id}',   [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
       
       

        // ── Subcategories ───────────────────────────
        Route::get('/subcategories',         [SubcategoryController::class, 'index'])->name('subcategories.index');
        Route::post('/subcategories',        [SubcategoryController::class, 'store'])->name('subcategories.store');
        Route::post('/subcategories/toggle-status', [SubcategoryController::class, 'toggleStatus'])->name('subcategories.toggle');
        Route::delete('/subcategories/remove-image/{id}',       [SubcategoryController::class, 'removeImage'])->name('subcategories.remove-image');
        Route::post('/subcategories/{id}',   [SubcategoryController::class, 'update'])->name('subcategories.update');
        Route::delete('/subcategories/{id}', [SubcategoryController::class, 'destroy'])->name('subcategories.destroy'); 
        

        // ── Child Subcategories ─────────────────────
        Route::get('/child-subcategories',           [ChildSubcategoryController::class, 'index'])->name('child.index');
        Route::post('/child-subcategories',          [ChildSubcategoryController::class, 'store'])->name('child.store');
        Route::post('/child-subcategories/toggle',   [ChildSubcategoryController::class, 'toggleStatus'])->name('child.toggle');
        Route::delete('/child-subcategories/remove-image/{id}', [ChildSubcategoryController::class, 'removeImage'])->name('child.remove-image');
        Route::post('/child-subcategories/{id}',     [ChildSubcategoryController::class, 'update'])->name('child.update');
        Route::delete('/child-subcategories/{id}',   [ChildSubcategoryController::class, 'destroy'])->name('child.destroy');
        Route::get('/get-subcategories',             [ChildSubcategoryController::class, 'getSubcategories'])->name('get.subcategories');

        // Products
    Route::get('/products/generate-sku',   [ProductController::class, 'generateSku'])->name('products.generate-sku');
    Route::get('/products/get-subs',       [ProductController::class, 'getSubcategories'])->name('products.get-subs');
    Route::get('/products/get-child-subs', [ProductController::class, 'getChildSubs'])->name('products.get-child-subs');
    Route::post('/products/bulk-delete',   [ProductController::class, 'bulkDelete'])->name('products.bulk-delete');
    Route::post('/products/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle');

    Route::get('/products',          [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create',   [ProductController::class, 'create'])->name('products.create');
    Route::post('/products',         [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}',     [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{id}/edit',[ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}',     [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}',  [ProductController::class, 'destroy'])->name('products.destroy');

    // ── Brands ─────────────────────────────────────────────
Route::post('/brands/toggle-status',     [BrandController::class, 'toggleStatus'])->name('brands.toggle');
Route::delete('/brands/{id}/remove-logo',[BrandController::class, 'removeLogo'])->name('brands.remove-logo');
Route::get('/brands',                    [BrandController::class, 'index'])->name('brands.index');
Route::post('/brands',                   [BrandController::class, 'store'])->name('brands.store');
Route::post('/brands/{id}',              [BrandController::class, 'update'])->name('brands.update');
Route::delete('/brands/{id}',            [BrandController::class, 'destroy'])->name('brands.destroy');

// ── Banners ────────────────────────────────────────────
// Admin group ke andar:
Route::post('/banners/toggle-status', [BannerController::class, 'toggleStatus'])->name('banners.toggle');
Route::get('/banners',                [BannerController::class, 'index'])->name('banners.index');
Route::get('/banners/create',         [BannerController::class, 'create'])->name('banners.create');
Route::post('/banners',               [BannerController::class, 'store'])->name('banners.store');
Route::get('/banners/{id}/edit',      [BannerController::class, 'edit'])->name('banners.edit');
Route::post('/banners/{id}',          [BannerController::class, 'update'])->name('banners.update');
Route::delete('/banners/{id}',        [BannerController::class, 'destroy'])->name('banners.destroy');

        
     });

     // ── Frontend ──────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product', [HomeController::class, 'product'])->name('product');