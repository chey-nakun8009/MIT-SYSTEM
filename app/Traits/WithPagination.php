<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait WithPagination
{
    protected function getPerPage(Request $request, int $default = 10): int
    {
        $perPage = $request->input('per_page', session('per_page', $default));
        $allowed = [15, 25, 50, 100];
        if (!in_array($perPage, $allowed)) {
            $perPage = $default;
        }
        session(['per_page' => $perPage]);
        return (int) $perPage;
    }
}
