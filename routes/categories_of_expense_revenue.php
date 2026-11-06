
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ExpenseRevenueCategoryController;
use App\Http\Controllers\Admin\ExpenseCategoryController;
use App\Http\Controllers\Admin\RevenueCategoryController;

Route::get('expense_revenue_category_index', [ExpenseRevenueCategoryController::class, 'mainIndex'])->name('expense_revenue_category_index');
Route::post('expense-categories/{expenseCategory}/copy', [ExpenseCategoryController::class, 'copy'])->name('expense-categories.copy');
Route::post('revenue-categories/{revenueCategory}/copy', [RevenueCategoryController::class, 'copy'])->name('revenue-categories.copy');
Route::resource('expense-categories', ExpenseCategoryController::class);
Route::resource('revenue-categories', RevenueCategoryController::class);
