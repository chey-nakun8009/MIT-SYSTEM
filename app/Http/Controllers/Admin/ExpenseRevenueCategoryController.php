<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
class ExpenseRevenueCategoryController extends Controller
{
    public function mainIndex()
    {
        return view('layouts.settings');
    }
}
