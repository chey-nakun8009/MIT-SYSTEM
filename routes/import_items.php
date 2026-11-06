
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\InventoryTransactionController;
use App\Http\Controllers\Admin\InventoryMultiTransactionController;

Route::get('inventory-transactions/product-units/{product}', [InventoryTransactionController::class, 'getProductUnits'])->name('inventory-transactions.product-units');
Route::get('inventory-transactions/product-units/{product}', [InventoryMultiTransactionController::class, 'getProductUnits'])->name('inventory-transactions.product-units');
Route::get('inventory-transactions-multiple-create', [InventoryMultiTransactionController::class, 'importMultipleItems'])->name('inventory-transactions.import-multiple-create');
Route::post('inventory-transactions-multiple-item', [InventoryMultiTransactionController::class, 'storeImportMultipleItems'])->name('inventory-transactions.store-multiple-item');
Route::get('inventory-transactions/edit-multiple', [InventoryMultiTransactionController::class, 'editMultiple'])->name('inventory-transactions.edit-multiple');
Route::put('inventory-transactions/update-multiple', [InventoryMultiTransactionController::class, 'updateMultiple'])->name('inventory-transactions.update-multiple');

Route::get('inventory-transactions/report/print/{reference_no?}', [InventoryTransactionController::class, 'printReport'])
    ->name('inventory-transactions.print-report');
Route::post('inventory-transactions/print-selected', [InventoryTransactionController::class, 'printSelected'])
    ->name('inventory-transactions.print-selected');
Route::resource('inventory-transactions', InventoryTransactionController::class);
