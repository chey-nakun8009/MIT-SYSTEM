<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\ProductSettingController;


// Route::get('/', [AdminController::class, 'index'])->name('index');
Route::get('/', function () {
    return redirect()->route('dashboard');
});
Route::get('/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {
    // Route::middleware(['auth', 'route.permission'])->group(function () {
    Route::resource('/users', UserController::class);
    Route::resource('/products', ProductController::class);
    Route::resource('/categories', CategoryController::class);
    Route::resource('/brands', BrandController::class);
    Route::resource('/units', UnitController::class);
    Route::resource('/product-variants', ProductVariantController::class);
    Route::resource('/attributes', AttributeController::class);
    Route::resource('attributes.values', AttributeValueController::class);
    Route::resource('/suppliers', SupplierController::class);

    Route::get('/product-settings', [ProductSettingController::class, 'index'])
        ->name('products.settings');
    Route::patch('/product-settings', [ProductSettingController::class, 'update'])
        ->name('products.settings.update');

    Route::resource('roles', RoleController::class)
        ->only([
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ]);

    require __DIR__ . '/import_items.php';
    require __DIR__ . '/reports.php';
    require __DIR__ . '/categories_of_expense_revenue.php';
    require __DIR__ . '/campuses.php';
    require __DIR__ . '/pos.php';
    Route::get('/system-settings', [SystemSettingController::class, 'index'])->name('system-settings.index');
    Route::patch('/system-settings', [SystemSettingController::class, 'update'])->name('system-settings.update');
});

require __DIR__ . '/auth.php';




Route::post('/language', [LanguageController::class, 'update'])
    ->name('language.update');
