<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Revenue;
use App\Models\Product;
use App\Models\User;
use App\Models\InventoryTransaction;

class AdminController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function dashboard()
    {
        $campusId = auth()->user()->campus_id;

        $totalRevenue = Revenue::where('campus_id', $campusId)->sum('amount');
        $totalExpenses = Expense::where('campus_id', $campusId)->sum('amount');
        $totalProducts = Product::where('campus_id', $campusId)->count();
        $totalUsers = User::where('campus_id', $campusId)->count();

        $recentTransactions = InventoryTransaction::where('campus_id', $campusId)
            ->with(['product', 'unit'])
            ->latest()
            ->take(5)
            ->get();

        $recentExpenses = Expense::where('campus_id', $campusId)
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        $recentRevenues = Revenue::where('campus_id', $campusId)
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalExpenses',
            'totalProducts',
            'totalUsers',
            'recentTransactions',
            'recentExpenses',
            'recentRevenues'
        ));
    }
    public function reports(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $revenueQuery = Revenue::query();
        $expenseQuery = Expense::query();

        if ($startDate && $endDate) {
            $revenueQuery->whereBetween('created_at', [$startDate, $endDate]);
            $expenseQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Fetch paginated or latest records with relationships eager-loaded
        $revenues = (clone $revenueQuery)->with(['category', 'user', 'campus'])->latest()->take(50)->get();
        $totalRevenue = (clone $revenueQuery)->sum('amount');

        // Note: If you don't have a 'status' column on revenues, adjust or remove these counts. 
        // For example, filtering by a specific category ID instead:
        $paidInvoicesCount = (clone $revenueQuery)->count(); // Placeholder total count

        // Fetch expenses with relationships eager-loaded
        $expenses = (clone $expenseQuery)->with(['category', 'user', 'campus'])->latest()->take(50)->get();
        $totalExpenses = (clone $expenseQuery)->sum('amount');

        // If you want to group operating/payroll costs, do it via category relationship or category ID:
        // Example: Assuming category ID 1 is Operations and ID 2 is Payroll
        $operatingCosts = (clone $expenseQuery)->whereHas('category', function ($q) {
            $q->where('name', 'like', '%Operations%');
        })->sum('amount');

        $payrollCosts = (clone $expenseQuery)->whereHas('category', function ($q) {
            $q->where('name', 'like', '%Payroll%');
        })->sum('amount');

        return view('admin.reports.index', compact(
            'revenues',
            'totalRevenue',
            'paidInvoicesCount',
            'expenses',
            'totalExpenses',
            'operatingCosts',
            'payrollCosts'
        ));
    }
}
