<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SpecificationController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{slug}', [ProductController::class, 'byCategory'])->name('products.category');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Article routes
Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/category/{slug}', [ArticleController::class, 'byCategory'])->name('articles.category');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// Page routes
Route::get('/pages/{slug}', [App\Http\Controllers\PageController::class, 'show'])->name('pages.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    
    // Settings routes
    Route::get('/settings/general', [SettingController::class, 'index'])->name('settings.general.index');
    Route::put('/settings/general', [SettingController::class, 'update'])->name('settings.general.update');
    Route::put('/settings/company', [SettingController::class, 'updateCompanyProfile'])->name('settings.company.update');
    
    // Product routes
    Route::resource('products', AdminProductController::class);
    Route::delete('products/{product}/images/{image}', [AdminProductController::class, 'deleteImage'])->name('products.deleteImage');
    Route::post('products/{product}/specifications', [AdminProductController::class, 'saveSpecification'])->name('products.saveSpecification');
    Route::delete('products/{product}/specifications/{specification}', [AdminProductController::class, 'deleteSpecification'])->name('products.deleteSpecification');
    Route::resource('product-categories', ProductCategoryController::class);
    
    // Post routes
    Route::resource('posts', PostController::class);
    Route::resource('post-categories', PostCategoryController::class);
    
    // Page routes
    Route::resource('pages', PageController::class);
    
    // Slider routes
    Route::resource('sliders', SliderController::class);
    
    // User routes
    Route::resource('users', UserController::class);
    
    // Menu routes
    Route::get('/menus', [App\Http\Controllers\Admin\MenuController::class, 'index'])->name('menus.index');
    Route::post('/menus', [App\Http\Controllers\Admin\MenuController::class, 'store'])->name('menus.store');
    Route::get('/menus/{menu}/edit', [App\Http\Controllers\Admin\MenuController::class, 'edit'])->name('menus.edit');
    Route::put('/menus/{menu}', [App\Http\Controllers\Admin\MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menus/{menu}', [App\Http\Controllers\Admin\MenuController::class, 'destroy'])->name('menus.destroy');
    Route::put('/menus/order', [App\Http\Controllers\Admin\MenuController::class, 'updateOrder'])->name('menus.order.update');
    Route::get('/menus/link-items/{linkType}', [App\Http\Controllers\Admin\MenuController::class, 'getLinkItems'])->name('menus.link-items');
    
    // Specification routes
    Route::resource('specifications', SpecificationController::class);
    
    // Partner routes
    Route::resource('partners', PartnerController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
