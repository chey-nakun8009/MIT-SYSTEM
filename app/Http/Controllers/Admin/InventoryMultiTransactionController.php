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

class InventoryMultiTransactionController extends Controller
{

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


    public function importMultipleItems()
    {
        $campusId = auth()->user()->campus_id;
        $products = Product::where('campus_id', $campusId)
            ->where('is_active', true)
            ->with(['baseUnit', 'unitOptions.unit'])
            ->orderBy('name')
            ->get();
        $expenseCategories = ExpenseCategory::where('campus_id', $campusId)->where('active', true)->orderBy('name')->get();
        return view('admin.inventory.multiple.create', compact('products', 'expenseCategories'));
    }
    public function storeImportMultipleItems(Request $request)
    {
        $campusId = auth()->user()->campus_id;
        $validator = Validator::make($request->all(), [
            'reference_no' => ['nullable', 'string', 'max:255'],
            'expense_category_id' => ['required', 'integer', 'exists:expense_categories,id'],
            'note' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.unit_id' => ['required', 'integer', 'exists:units,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.001'],
            'items.*.cost_price' => ['nullable', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please check the form inputs.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $totalBatchCost = 0;

        try {
            DB::beginTransaction();

            foreach ($validated['items'] as $item) {
                $product = Product::where('id', $item['product_id'])
                    ->where('campus_id', $campusId)
                    ->with(['baseUnit', 'unitOptions'])
                    ->first();

                if (! $product) {
                    throw new \Exception("Product ID {$item['product_id']} not found or unauthorized.");
                }

                if ($item['unit_id'] == $product->base_unit_id) {
                    $conversionFactor = 1.000000;
                } else {
                    $unitOption = $product->unitOptions->where('unit_id', $item['unit_id'])->first();
                    if (! $unitOption) {
                        throw new \Exception("Invalid unit option for product: {$product->name}");
                    }
                    $conversionFactor = $unitOption->conversion_factor;
                }

                $baseQuantityToAdd = $item['quantity'] * $conversionFactor;
                InventoryTransaction::create([
                    'campus_id' => $campusId,
                    'product_id' => $product->id,
                    'unit_id' => $item['unit_id'],
                    'quantity' => $item['quantity'],
                    'conversion_factor' => $conversionFactor,
                    'base_quantity' => $baseQuantityToAdd,
                    'cost_price' => $item['cost_price'] ?? null,
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
                $itemCost = ($item['quantity'] ?? 0) * ($item['cost_price'] ?? 0);
                $totalBatchCost += $itemCost;
            }
            if ($totalBatchCost > 0) {
                Expense::updateOrCreate(
                    [
                        'campus_id' => $campusId,
                        'reference_no' => $validated['reference_no'] ?? null,
                    ],
                    [
                        'expense_category_id' => $validated['expense_category_id'],
                        'amount' => $totalBatchCost,
                        'note' => 'Batch Inventory Import (Ref: ' . ($validated['reference_no'] ?? 'N/A') . ')',
                        'user_id' => auth()->id(),
                    ]
                );
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Multiple inventory transactions and expense recorded successfully.',
                'redirect' => route('inventory-transactions.index'),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage() ?: 'Failed to record bulk transactions.',
            ], 500);
        }
    }
    public function editMultiple(Request $request)
    {
        $campusId = auth()->user()->campus_id;
        $referenceNo = $request->query('reference_no');

        if (! $referenceNo) {
            return redirect()->route('inventory-transactions.index')->with('error', 'Reference number required for batch editing.');
        }

        $transactions = InventoryTransaction::where('campus_id', $campusId)
            ->where('reference_no', $referenceNo)
            ->with(['product.baseUnit', 'unit'])
            ->get();

        if ($transactions->isEmpty()) {
            return redirect()->route('inventory-transactions.index')->with('error', 'Batch transaction not found.');
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
        $linkedExpense = Expense::where('campus_id', $campusId)
            ->where('reference_no', $referenceNo)
            ->first();

        return view('admin.inventory.multiple.edit', compact('transactions', 'referenceNo', 'products', 'expenseCategories', 'linkedExpense'));
    }

    public function updateMultiple(Request $request)
    {
        $campusId = auth()->user()->campus_id;

        $validator = Validator::make($request->all(), [
            'reference_no' => ['required', 'string', 'max:255'],
            'expense_category_id' => ['required', 'integer', 'exists:expense_categories,id'],
            'note' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.unit_id' => ['required', 'integer', 'exists:units,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.001'],
            'items.*.cost_price' => ['nullable', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please check the form inputs.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $referenceNo = $validated['reference_no'];
        $totalBatchCost = 0;

        try {
            DB::beginTransaction();
            $oldTransactions = InventoryTransaction::where('campus_id', $campusId)
                ->where('reference_no', $referenceNo)
                ->get();

            foreach ($oldTransactions as $oldTx) {
                $inventory = Inventory::where('campus_id', $campusId)
                    ->where('product_id', $oldTx->product_id)
                    ->whereNull('product_variant_id')
                    ->first();

                if ($inventory) {
                    $inventory->quantity -= $oldTx->base_quantity;
                    $inventory->save();
                }
            }
            InventoryTransaction::where('campus_id', $campusId)
                ->where('reference_no', $referenceNo)
                ->delete();
            foreach ($validated['items'] as $item) {
                $product = Product::where('id', $item['product_id'])
                    ->where('campus_id', $campusId)
                    ->with(['baseUnit', 'unitOptions'])
                    ->first();

                if (! $product) {
                    throw new \Exception("Product ID {$item['product_id']} not found.");
                }

                if ($item['unit_id'] == $product->base_unit_id) {
                    $conversionFactor = 1.000000;
                } else {
                    $unitOption = $product->unitOptions->where('unit_id', $item['unit_id'])->first();
                    if (! $unitOption) {
                        throw new \Exception("Invalid unit option for: {$product->name}");
                    }
                    $conversionFactor = $unitOption->conversion_factor;
                }

                $baseQuantityToAdd = $item['quantity'] * $conversionFactor;

                InventoryTransaction::create([
                    'campus_id' => $campusId,
                    'product_id' => $product->id,
                    'unit_id' => $item['unit_id'],
                    'quantity' => $item['quantity'],
                    'conversion_factor' => $conversionFactor,
                    'base_quantity' => $baseQuantityToAdd,
                    'cost_price' => $item['cost_price'] ?? null,
                    'reference_no' => $referenceNo,
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

                $itemCost = ($item['quantity'] ?? 0) * ($item['cost_price'] ?? 0);
                $totalBatchCost += $itemCost;
            }
            if ($totalBatchCost > 0) {
                Expense::updateOrCreate(
                    [
                        'campus_id' => $campusId,
                        'reference_no' => $referenceNo,
                    ],
                    [
                        'expense_category_id' => $validated['expense_category_id'],
                        'amount' => $totalBatchCost,
                        'note' => 'Batch Inventory Import (Ref: ' . $referenceNo . ')',
                        'user_id' => auth()->id(),
                    ]
                );
            } else {
                Expense::where('campus_id', $campusId)
                    ->where('reference_no', $referenceNo)
                    ->delete();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Multiple inventory transactions and expense updated successfully.',
                'redirect' => route('inventory-transactions.index'),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage() ?: 'Failed to update batch transactions.',
            ], 500);
        }
    }
}
