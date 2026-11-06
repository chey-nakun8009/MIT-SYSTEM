<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function expenses(Request $request)
    {
        $query = Expense::query();
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $expenses = $query->with(['category', 'user'])->latest()->get();
        $totalExpenses = (clone $query)->sum('amount');

        $operatingCosts = (clone $query)->whereHas('category', function ($q) {
            $q->where('name', 'like', '%Operations%');
        })->sum('amount');
        $payrollCosts = (clone $query)->whereHas('category', function ($q) {
            $q->where('name', 'like', '%Payroll%');
        })->sum('amount');
        return view('admin.reports.expense._expenses', compact(
            'expenses',
            'totalExpenses',
            'operatingCosts',
            'payrollCosts'
        ));
    }

    public function printSelectedExpense(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->back()->with('error', 'សូមជ្រើសរើសប្រតិបត្តិការយ៉ាងតិច១ ដើម្បីបោះពុម្ព។');
        }
        $expenses = Expense::whereIn('id', $ids)
            ->with(['category', 'user'])
            ->latest()
            ->get();

        $totalExpenses = $expenses->sum('amount');

        return view('admin.reports.expense.print-selected', compact('expenses', 'totalExpenses'));
    }
}
