<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Expense;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InventoryTransactionController extends Controller
{
    public function index(Request $request)
    {
        $campusId = auth()->user()->campus_id;
        $query = InventoryTransaction::where('campus_id', $campusId)
            ->with(['product.baseUnit', 'unit', 'user'])
            ->oldest();
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference_no', 'like', "%{$search}%")
                    ->orWhereHas('product', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%")
                            ->orWhere('sku', 'like', "%{$search}%");
                    });
            });
        }

        $transactions = $query->orderBy('created_at', 'asc')->paginate(15)->withQueryString();
        if ($request->ajax()) {
            return view('admin.inventory.partials._group', compact('transactions'));
        }
        return view('admin.inventory.index', compact('transactions'));
    }
    public function create()
    {
        $campusId = auth()->user()->campus_id;
        $products = Product::where('campus_id', $campusId)
            ->where('is_active', true)
            ->with(['baseUnit', 'unitOptions.unit'])
            ->orderBy('name')
            ->get();
        $expenseCategories = ExpenseCategory::where('campus_id', $campusId)->where('active', true)->orderBy('name')->get();
        return view('admin.inventory.single.create', compact('products', 'expenseCategories'));
    }

    public function getProductUnits(Product $product)
    {
        $campusId = auth()->user()->campus_id;

        if ($product->campus_id !== $campusId) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $product->load(['unitOptions.unit', 'baseUnit']);

        $unitOptions = $product->unitOptions;
        if ($unitOptions->isEmpty() && $product->baseUnit) {
            $unitOptions = collect([
                (object) [
                    'unit_id' => $product->base_unit_id,
                    'conversion_factor' => 1.00,
                    'unit' => $product->baseUnit
                ]
            ]);
        }

        return response()->json([
            'status' => true,
            'base_unit' => $product->baseUnit,
            'unit_options' => $unitOptions,
        ]);
    }
    public function store(Request $request)
    {
        $campusId = auth()->user()->campus_id;
        $validator = Validator::make($request->all(), [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'unit_id' => ['required', 'integer', 'exists:units,id'],
            'quantity' => ['required', 'numeric', 'min:0.001'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'expense_category_id' => ['required', 'integer', 'exists:expense_categories,id'],
            'reference_no' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please check the form.',
                'errors' => $validator->errors(),
            ], 422);
        }
        $validated = $validator->validated();
        $product = Product::where('id', $validated['product_id'])->where('campus_id', $campusId)->with('unitOptions')->first();
        if (! $product) {
            return response()->json(['status' => false, 'message' => 'Product not found.'], 422);
        }
        $unitOption = $product->unitOptions->where('unit_id', $validated['unit_id'])->first();
        if (! $unitOption) {
            return response()->json(['status' => false, 'message' => 'Invalid unit option for this product.'], 422);
        }
        $conversionFactor = $unitOption->conversion_factor;
        $baseQuantityToAdd = $validated['quantity'] * $conversionFactor;
        try {
            DB::beginTransaction();
            InventoryTransaction::create([
                'campus_id' => $campusId,
                'product_id' => $product->id,
                'unit_id' => $validated['unit_id'],
                'quantity' => $validated['quantity'],
                'conversion_factor' => $conversionFactor,
                'base_quantity' => $baseQuantityToAdd,
                'cost_price' => $validated['cost_price'] ?? null,
                'reference_no' => $validated['reference_no'] ?? null,
                'note' => $validated['note'] ?? null,
                'user_id' => auth()->id(),
            ]);
            $inventory = Inventory::firstOrNew([
                'campus_id' => $campusId,
                'product_id' => $product->id,
                'product_variant_id' => null,
            ]);
            $inventory->quantity = ($inventory->quantity ?? 0) + $baseQuantityToAdd;
            $inventory->save();
            $costPrice = $validated['cost_price'] ?? 0;
            $totalAmount = $validated['quantity'] * $costPrice;
            if ($totalAmount > 0) {
                Expense::create([
                    'campus_id' => $campusId,
                    'expense_category_id' => $validated['expense_category_id'],
                    'amount' => $totalAmount,
                    'reference_no' => $validated['reference_no'] ?? null,
                    'note' => 'Inventory Import: ' . $product->name . ($validated['reference_no'] ? ' (Ref: ' . $validated['reference_no'] . ')' : ''),
                    'user_id' => auth()->id(),
                ]);
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Inventory transaction and expense recorded successfully.',
                'redirect' => route('inventory-transactions.index'),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Failed to record transaction.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function edit(InventoryTransaction $inventoryTransaction)
    {
        $campusId = auth()->user()->campus_id;
        if ($inventoryTransaction->campus_id !== $campusId) {
            abort(403, 'Unauthorized action.');
        }

        $products = Product::where('campus_id', $campusId)
            ->where('is_active', true)
            ->with(['baseUnit', 'unitOptions.unit'])
            ->orderBy('name')
            ->get();

        $expenseCategories = ExpenseCategory::where('campus_id', $campusId)
            ->where('active', true)
            ->orderBy('name')
            ->get();
        $linkedExpense = null;
        if ($inventoryTransaction->reference_no) {
            $linkedExpense = Expense::where('campus_id', $campusId)
                ->where('reference_no', $inventoryTransaction->reference_no)
                ->first();
        }

        return view('admin.inventory.single.edit', compact(
            'inventoryTransaction',
            'products',
            'expenseCategories',
            'linkedExpense'
        ));
    }
    public function update(Request $request, InventoryTransaction $inventoryTransaction)
    {
        $campusId = auth()->user()->campus_id;

        if ($inventoryTransaction->campus_id !== $campusId) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'unit_id' => ['required', 'integer', 'exists:units,id'],
            'quantity' => ['required', 'numeric', 'min:0.001'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'expense_category_id' => ['required', 'integer', 'exists:expense_categories,id'],
            'reference_no' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please check the form inputs.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $product = Product::where('id', $validated['product_id'])
            ->where('campus_id', $campusId)
            ->with(['baseUnit', 'unitOptions'])
            ->first();

        if (! $product) {
            return response()->json(['status' => false, 'message' => 'Product not found.'], 422);
        }
        if ($validated['unit_id'] == $product->base_unit_id) {
            $conversionFactor = 1.000000;
        } else {
            $unitOption = $product->unitOptions->where('unit_id', $validated['unit_id'])->first();
            if (! $unitOption) {
                return response()->json(['status' => false, 'message' => 'Invalid unit option.'], 422);
            }
            $conversionFactor = $unitOption->conversion_factor;
        }

        $newBaseQuantity = $validated['quantity'] * $conversionFactor;
        $oldBaseQuantity = $inventoryTransaction->base_quantity;
        $oldProductId = $inventoryTransaction->product_id;
        $oldReferenceNo = $inventoryTransaction->reference_no;

        try {
            DB::beginTransaction();
            if ($oldProductId === $product->id) {
                $inventory = Inventory::where('campus_id', $campusId)
                    ->where('product_id', $product->id)
                    ->whereNull('product_variant_id')
                    ->first();

                if ($inventory) {
                    $inventory->quantity = ($inventory->quantity - $oldBaseQuantity) + $newBaseQuantity;
                    $inventory->save();
                }
            } else {
                $oldInventory = Inventory::where('campus_id', $campusId)
                    ->where('product_id', $oldProductId)
                    ->whereNull('product_variant_id')
                    ->first();
                if ($oldInventory) {
                    $oldInventory->quantity -= $oldBaseQuantity;
                    $oldInventory->save();
                }
                $newInventory = Inventory::firstOrNew([
                    'campus_id' => $campusId,
                    'product_id' => $product->id,
                    'product_variant_id' => null,
                ]);
                $newInventory->quantity = ($newInventory->quantity ?? 0) + $newBaseQuantity;
                $newInventory->save();
            }
            $inventoryTransaction->update([
                'product_id' => $product->id,
                'unit_id' => $validated['unit_id'],
                'quantity' => $validated['quantity'],
                'conversion_factor' => $conversionFactor,
                'base_quantity' => $newBaseQuantity,
                'cost_price' => $validated['cost_price'] ?? null,
                'reference_no' => $validated['reference_no'] ?? null,
                'note' => $validated['note'] ?? null,
            ]);
            $costPrice = $validated['cost_price'] ?? 0;
            $newTotalAmount = $validated['quantity'] * $costPrice;
            $expense = null;
            if ($oldReferenceNo) {
                $expense = Expense::where('campus_id', $campusId)
                    ->where('reference_no', $oldReferenceNo)
                    ->first();
            }

            if ($newTotalAmount > 0) {
                if ($expense) {
                    $expense->update([
                        'expense_category_id' => $validated['expense_category_id'],
                        'amount' => $newTotalAmount,
                        'reference_no' => $validated['reference_no'] ?? null,
                        'note' => 'Inventory Import: ' . $product->name . ($validated['reference_no'] ? ' (Ref: ' . $validated['reference_no'] . ')' : ''),
                    ]);
                } else {
                    Expense::create([
                        'campus_id' => $campusId,
                        'expense_category_id' => $validated['expense_category_id'],
                        'amount' => $newTotalAmount,
                        'reference_no' => $validated['reference_no'] ?? null,
                        'note' => 'Inventory Import: ' . $product->name . ($validated['reference_no'] ? ' (Ref: ' . $validated['reference_no'] . ')' : ''),
                        'user_id' => auth()->id(),
                    ]);
                }
            } elseif ($expense) {
                $expense->delete();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Inventory transaction and expense updated successfully.',
                'redirect' => route('inventory-transactions.index'),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Failed to update transaction.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function destroy(InventoryTransaction $inventoryTransaction)
    {
        $campusId = auth()->user()->campus_id;
        if ($inventoryTransaction->campus_id !== $campusId) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }
        try {
            DB::beginTransaction();
            $inventory = Inventory::where('campus_id', $campusId)->where('product_id', $inventoryTransaction->product_id)->whereNull('product_variant_id')->first();
            if ($inventory) {
                $inventory->quantity -= $inventoryTransaction->base_quantity;
                $inventory->save();
            }
            if ($inventoryTransaction->reference_no) {
                Expense::where('campus_id', $campusId)->where('reference_no', $inventoryTransaction->reference_no)->delete();
            } else {
                $itemTotal = ($inventoryTransaction->quantity ?? 0) * ($inventoryTransaction->cost_price ?? 0);
                if ($itemTotal > 0 && $inventoryTransaction->product) {
                    Expense::where('campus_id', $campusId)->whereNull('reference_no')->where('amount', $itemTotal)->where('note', 'like', '%' . $inventoryTransaction->product->name . '%')->latest()->first()?->delete();
                }
            }
            $inventoryTransaction->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Inventory transaction, stock reversal, and expense deleted successfully.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete transaction.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function printReport(Request $request, $referenceNo = null)
    {
        $campusId = auth()->user()->campus_id;
        $campus = auth()->user()->campus;

        $query = InventoryTransaction::where('campus_id', $campusId)
            ->with(['product.baseUnit', 'unit', 'user']);
        if ($referenceNo) {
            $query->where('reference_no', $referenceNo);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }
        $transactions = $query->latest()->get();
        $expense = null;
        if ($referenceNo) {
            $expense = Expense::where('campus_id', $campusId)
                ->where('reference_no', $referenceNo)
                ->with('category')
                ->first();
        }

        return view('admin.inventory.reports.print', compact(
            'transactions',
            'referenceNo',
            'campus',
            'expense'
        ));
    }
    public function printSelected(Request $request)
    {
        $campusId = auth()->user()->campus_id;
        $campus = auth()->user()->campus;

        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'សូមជ្រើសរើសប្រតិបត្តិការយ៉ាងតិច១ ដើម្បីបោះពុម្ព។');
        }

        $transactions = InventoryTransaction::where('campus_id', $campusId)
            ->whereIn('id', $ids)
            ->with(['product.baseUnit', 'unit', 'user'])
            ->latest()
            ->get();

        return view('admin.inventory.reports.print-selected', compact('transactions', 'campus'));
    }
}
