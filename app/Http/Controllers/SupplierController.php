<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::with('store')
            ->where('store_id', auth()->user()->store_id);

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('tax_number', 'like', "%{$search}%");
            });
        }
        $suppliers = $query->oldest()->paginate(10)->withQueryString();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => view('admin.supplier.partials._row', compact('suppliers'))->render(),
                'pagination' => $suppliers->links('vendor.pagination.bootstrap-5')->render(),
            ]);
        }
        return view('admin.supplier.index', compact('suppliers'));
    }
    public function create()
    {
        return view('admin.supplier.create', [
            'page' => request('page', 1),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'tax_number' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'សូមបំពេញ ឈ្មោះអ្នកផ្គត់ផ្គង់។',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'សូមបំពេញព៍ត័មានលម្អិតសម្រាប់អ្នកផ្គត់ផ្គង់ឲ្យបានត្រឹមត្រូវ.',
                'errors' => $validator->errors(),
            ], 422);
        }
        Supplier::create([
            'store_id' => auth()->user()->store_id,
            'name' => $request->name,
            'company_name' => $request->company_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'tax_number' => $request->tax_number,
            'notes' => $request->notes,
            'is_active' => $request->boolean('is_active'),
        ]);
        return response()->json([
            'success' => true,
            'message' => 'អ្នកផ្គត់ផ្គង់ថ្មីបង្កើតបានជោកជ័យ!',
            'redirect' => route('suppliers.index')
        ]);
    }
    public function edit(Supplier $supplier)
    {
        return view('admin.supplier.edit', [
            'supplier' => $supplier,
            'page' => request('page', 1),
        ]);
    }
    public function update(Request $request, Supplier $supplier)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'tax_number' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'សូមបំពេញ ឈ្មោះអ្នកផ្គត់ផ្គង់។',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'សូមបំពេញព័ត៌មានលម្អិតសម្រាប់អ្នកផ្គត់ផ្គង់ឲ្យបានត្រឹមត្រូវ។',
                'errors' => $validator->errors(),
            ], 422);
        }

        $supplier->update([
            'name' => $request->name,
            'company_name' => $request->company_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'tax_number' => $request->tax_number,
            'notes' => $request->notes,
            'is_active' => $request->boolean('is_active'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'អ្នកផ្គត់ផ្គង់បានកែប្រែដោយជោគជ័យ!',
            'redirect' => route('suppliers.index', [
                'page' => $request->page ?: 1,
            ]),
        ]);
    }
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        if ($supplier->store_id !== auth()->user()->store_id) {
            return response()->json([
                'success' => false,
                'message' => 'អ្នកមិនអាចលុបអ្នកផ្គត់ផ្គង់របស់ហាងផ្សេងបានទេ។'
            ], 403);
        }
        $supplier->delete();
        return response()->json([
            'success' => true,
            'message' => 'អ្នកផ្គត់ផ្គង់បានលុបដោយជោគជ័យ!',
            'redirect' => route('suppliers.index', [
                'page' => request('page', 1),
            ]),
        ]);
    }
}
