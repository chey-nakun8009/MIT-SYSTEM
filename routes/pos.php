<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pos\PosController;


Route::middleware(['auth'])->group(function () {
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::get('/pos/receipt/{orderId}', [PosController::class, 'printReceipt'])->name('pos.receipt');
    Route::get('orders', [PosController::class, 'orderIndex'])->name('orders.index');
    Route::post('/pos/orders/print-selected', [PosController::class, 'printSelectedOrders'])->name('pos.orders.print-selected');
});
Route::middleware(['auth'])->prefix('api/pos')->group(function () {
    Route::get('/products', [PosController::class, 'getProducts']);
    Route::post('/checkout', [PosController::class, 'store']);
    Route::delete('/orders/{id}', [PosController::class, 'destroyOrder'])->name('api.pos.order.destroy');
});
