<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $units = Unit::where('campus_id', auth()->user()->campus_id)
            ->oldest()
            ->paginate(15)
            ->withQueryString();

        if ($request->ajax() || $request->wantsJson()) {
            return view('admin.unit.partials._content', compact('units'));
        }

        return view('admin.unit.index', compact('units'));
    }

    public function create()
    {
        return view('admin.unit.create', [
            'page' => request('page', 1),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'symbol' => ['required', 'string', 'max:20'],
            'type' => ['required', 'string', 'max:30'],
            'decimal_places' => ['required', 'integer', 'min:0', 'max:6'],
        ], [
            'name.required' => __('unit.validation.name_required'),
            'symbol.required' => __('unit.validation.symbol_required'),
            'type.required' => __('unit.validation.type_required'),
            'decimal_places.required' => __('unit.validation.decimal_places_required'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => __('validation.failed'),
                'errors' => $validator->errors(),
            ], 422);
        }

        Unit::create([
            'campus_id' => auth()->user()->campus_id,
            'name' => $request->name,
            'symbol' => $request->symbol,
            'type' => $request->type,
            'decimal_places' => $request->decimal_places,
        ]);

        return response()->json([
            'status' => true,
            'message' => __('unit.created_successfully'),
            'redirect' => route('units.index')
        ]);
    }

    public function edit(Unit $unit)
    {
        abort_unless(
            $unit->campus_id === auth()->user()->campus_id,
            403
        );

        $page = request('page', 1);

        if (request()->ajax() || request()->wantsJson()) {
            return view('admin.unit.edit', compact('unit', 'page'));
        }

        return view('admin.unit.edit', compact('unit', 'page'));
    }

    public function update(Request $request, Unit $unit)
    {
        abort_unless(
            $unit->campus_id === auth()->user()->campus_id,
            403
        );

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'symbol' => ['required', 'string', 'max:20'],
            'type' => ['required', 'string', 'max:30'],
            'decimal_places' => ['required', 'integer', 'min:0', 'max:6'],
        ], [
            'name.required' => __('unit.validation.name_required'),
            'symbol.required' => __('unit.validation.symbol_required'),
            'type.required' => __('unit.validation.type_required'),
            'decimal_places.required' => __('unit.validation.decimal_places_required'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => __('validation.failed'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $unit->update([
            'name' => $request->name,
            'symbol' => $request->symbol,
            'type' => $request->type,
            'decimal_places' => $request->decimal_places,
        ]);

        return response()->json([
            'status' => true,
            'message' => __('unit.updated_successfully'),
            'redirect' => route('units.index', [
                'page' => $request->page ?? 1,
            ]),
        ]);
    }

    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);

        if ($unit->campus_id !== auth()->user()->campus_id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete a unit from another campus.',
            ], 403);
        }

        $unit->delete();

        $currentPage = (int) request('page', 1);
        $perPage = 15;
        $total = Unit::where('campus_id', auth()->user()->campus_id)->count();
        $lastPage = max(1, (int) ceil($total / $perPage));
        $page = min($currentPage, $lastPage);

        return response()->json([
            'success' => true,
            'message' => __('unit.deleted_successfully'),
            'redirect' => route('units.index', [
                'page' => $page,
            ]),
        ]);
    }
}
