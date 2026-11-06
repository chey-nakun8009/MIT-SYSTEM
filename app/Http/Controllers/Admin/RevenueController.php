<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Revenue;

class RevenueController extends Controller
{
    public function revenues(Request $request)
    {
        $query = Revenue::query();

        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $revenues = $query->with(['category', 'user'])->latest()->take(50)->get();
        $totalRevenue = (clone $query)->sum('amount');
        $totalRecords = (clone $query)->count();

        return view('admin.reports.revenue._revenues', compact('revenues', 'totalRevenue', 'totalRecords'));
    }

    public function printSelectedRevenue(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->back()->with('error', 'សូមជ្រើសរើសប្រតិបត្តិការយ៉ាងតិច១ ដើម្បីបោះពុម្ព។');
        }
        $revenues = Revenue::whereIn('id', $ids)
            ->with(['category', 'user'])
            ->latest()
            ->get();
        $totalRevenue = $revenues->sum('amount');
        return view('admin.reports.revenue.print-selected', compact('revenues', 'totalRevenue'));
    }
}
