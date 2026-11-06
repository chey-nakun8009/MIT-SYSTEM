
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\RevenueController;
use App\Http\Controllers\Admin\AdminController;

Route::get('reports', [AdminController::class, 'reports'])->name('reports');
Route::name('reports.')->group(function () {
    Route::get('reports/revenues', [RevenueController::class, 'revenues'])->name('revenues');
    Route::get('reports/expenses', [ExpenseController::class, 'expenses'])->name('expenses');

    Route::post('reports/expenses/print-selected', [ExpenseController::class, 'printSelectedExpense'])->name('expenses.print-selected');
    Route::post('reports/revenues/print-selected', [RevenueController::class, 'printSelectedRevenue'])->name('revenues.print-selected');
});
