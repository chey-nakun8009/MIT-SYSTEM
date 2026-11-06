<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Category;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Revenue;
use App\Models\InventoryTransaction;
use App\Traits\WithPagination;

class PosController extends Controller
{
    use WithPagination;
    public function index()
    {
        $categories = Category::select('id', 'name')->get();
        $customers = User::select('id', 'last_name')->get();
        $products = Product::with(['unitOptions.unit', 'unit', 'inventory', 'images'])
            ->where('is_active', true)
            ->get();
        return view('pos.index', compact('categories', 'customers', 'products'));
    }
    const EXCHANGE_RATE = 4000;
    public function getProducts(Request $request)
    {
        $campusId = $request->get('campus_id', auth()->user()->campus_id ?? 1);
        $products = Product::where('campus_id', $campusId)
            ->where('is_active', true)
            ->with([
                'unit',
                'unitOptions' => function ($query) use ($campusId) {
                    $query->where('campus_id', $campusId)->where('is_active', true);
                },
                'variants' => function ($query) use ($campusId) {
                    $query->where('campus_id', $campusId)->where('is_active', true);
                }
            ])
            ->get()
            ->map(function ($product) {
                $defaultOption = $product->unitOptions->where('is_default', true)->first()
                    ?? $product->unitOptions->first();

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'unit_id' => $defaultOption?->unit_id ?? $product->base_unit_id,
                    'unit_symbol' => $defaultOption?->unit?->symbol ?? 'unit',
                    'conversion_factor' => $defaultOption?->conversion_factor ?? 1,
                    'price' => $defaultOption?->price ?? 0.00,
                ];
            });

        return response()->json($products);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'      => 'nullable',
            'discount_type'    => 'required|in:amount,percent',
            'discount_value'   => 'required|numeric|min:0',
            'cart_discount'    => 'nullable|numeric|min:0',
            'receive_currency' => 'required|in:USD,KHR',
            'received_amount'  => 'required|numeric|min:0',
            'payment_method'   => 'required|in:cash,khqr,card',
            'items'            => 'required|array|min:1',
            'items.*.id'       => 'required|exists:products,id',
            'items.*.qty'      => 'required|numeric|min:0.001',
            'items.*.price'    => 'nullable|numeric|min:0',
        ]);

        try {
            $calcData = [];

            $order = DB::transaction(function () use ($validated, $request, &$calcData) {

                $subtotal = 0;
                $processedItems = [];
                $firstCampusId = 1;

                foreach ($validated['items'] as $itemData) {
                    $product = Product::with(['unit', 'unitOptions'])->findOrFail($itemData['id']);

                    $qty = $itemData['qty'];
                    $productCampusId = $product->campus_id ?? 1;

                    if ($firstCampusId === 1 && $productCampusId) {
                        $firstCampusId = $productCampusId;
                    }
                    $unitId = $itemData['unit_id'] ?? $product->base_unit_id;
                    $unitOption = $product->unitOptions()
                        ->where('campus_id', $productCampusId)
                        ->where('unit_id', $unitId)
                        ->first();

                    $unitPrice = $unitOption->price ?? $itemData['price'] ?? 0;
                    $unitSymbol = $unitOption?->unit?->symbol ?? $product->unit?->symbol ?? 'unit';
                    $conversionFactor = $unitOption?->conversion_factor ?? 1;

                    $itemTotal = $unitPrice * $qty;
                    $subtotal += $itemTotal;

                    $processedItems[] = [
                        'campus_id'         => $productCampusId,
                        'product_id'        => $product->id,
                        'unit_id'           => $unitId,
                        'product_name'      => $product->name,
                        'unit_symbol'       => $unitSymbol,
                        'quantity'          => $qty,
                        'conversion_factor' => $conversionFactor,
                        'unit_price'        => $unitPrice,
                        'total'             => $itemTotal,
                    ];
                }

                $discountInput = $validated['discount_value'] ?? 0;
                $discountAmount = 0;

                if ($validated['discount_type'] === 'percent') {
                    $discountAmount = $subtotal * ($discountInput / 100);
                } else {
                    $discountAmount = $discountInput;
                }

                $grandTotal = max(0, $subtotal - $discountAmount);
                $receivedAmount = $validated['received_amount'];
                $receiveCurrency = $validated['receive_currency'];

                $changeUsd = 0;
                $changeKhr = 0;

                if ($receiveCurrency === 'KHR') {
                    $grandTotalKhr = $grandTotal * self::EXCHANGE_RATE;
                    $changeAmountKhr = max(0, $receivedAmount - $grandTotalKhr);

                    $changeKhr = $changeAmountKhr;
                    $changeUsd = $changeAmountKhr / self::EXCHANGE_RATE;
                } else {
                    $changeAmountUsd = max(0, $receivedAmount - $grandTotal);

                    $changeUsd = $changeAmountUsd;
                    $changeKhr = $changeAmountUsd * self::EXCHANGE_RATE;
                }

                $calcData['change_usd'] = round($changeUsd, 3);
                $calcData['change_khr'] = round($changeKhr, 2);

                $orderNumber = 'ORD-' . date('Ymd') . '-' . str_pad(Order::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
                $currentUserId = auth()->id() ?? ($validated['customer_id'] !== 'walkin' && is_numeric($validated['customer_id']) ? $validated['customer_id'] : 1);

                $order = Order::create([
                    'order_number'    => $orderNumber,
                    'campus_id'       => $firstCampusId,
                    'user_id'         => $currentUserId,
                    'subtotal'        => $subtotal,
                    'tax_amount'      => 0.00,
                    'shipping_amount' => 0.00,
                    'discount_amount' => $discountAmount,
                    'grand_total'     => $grandTotal,
                    'currency'        => 'USD',
                    'status'          => 'completed',
                    'payment_status'  => 'paid',
                    'shipping_status' => 'delivered',
                    'customer_email'  => $request->input('customer_email', 'walkin@pos.local'),
                    'customer_phone'  => $request->input('customer_phone', null),
                    'shipping_address' => [],
                    'billing_address' => [],
                    'notes'           => 'POS Transaction - Paid via ' . strtoupper($validated['payment_method']),
                ]);

                foreach ($processedItems as $item) {
                    OrderItem::create([
                        'campus_id'         => $item['campus_id'],
                        'order_id'          => $order->id,
                        'product_id'        => $item['product_id'],
                        'unit_id'           => $item['unit_id'],
                        'product_name'      => $item['product_name'],
                        'unit_symbol'       => $item['unit_symbol'],
                        'quantity'          => $item['quantity'],
                        'conversion_factor' => $item['conversion_factor'],
                        'unit_price'        => $item['unit_price'],
                        'total'             => $item['total'],
                    ]);

                    DB::table('inventories')
                        ->where('campus_id', $item['campus_id'])
                        ->where('product_id', $item['product_id'])
                        ->whereNull('product_variant_id')
                        ->decrement('quantity', $item['quantity']);
                }

                Revenue::create([
                    'campus_id'           => $firstCampusId,
                    'revenue_category_id' => 1,
                    'amount'              => $grandTotal,
                    'reference_no'        => $orderNumber,
                    'note'                => 'ចំណូលពីការលក់ #' . $orderNumber,
                    'user_id'             => $currentUserId,
                ]);

                return $order;
            });

            return response()->json([
                'success'    => true,
                'message'    => 'Order and revenue recorded successfully.',
                'order'      => $order->load('items'),
                'change_usd' => $calcData['change_usd'],
                'change_khr' => $calcData['change_khr']
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function printReceipt($orderId)
    {
        $campusId = auth()->user()->campus_id ?? 1;
        $campus = auth()->user()->campus;
        $order = Order::with(['items', 'user'])->findOrFail($orderId);
        $referenceNo = $order->order_number;
        $transactions = \App\Models\InventoryTransaction::where('campus_id', $campusId)
            ->where('reference_no', $referenceNo)
            ->with(['product.baseUnit', 'unit', 'user'])
            ->get();
        return view('pos.partials.print_a5', compact(
            'order',
            'transactions',
            'referenceNo',
            'campus'
        ));
    }

    public function destroyOrder(Order $order)
    {
        $campusId = auth()->user()->campus_id ?? 1;
        if ($order->campus_id !== $campusId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        try {
            DB::transaction(function () use ($order) {
                foreach ($order->items as $item) {
                    DB::table('inventories')
                        ->where('campus_id', $item->campus_id)
                        ->where('product_id', $item->product_id)
                        ->whereNull('product_variant_id')
                        ->increment('quantity', $item->quantity);
                }
                Revenue::where('reference_no', $order->order_number)->delete();
                $order->items()->delete();
                $order->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully and inventory restored!',
                'redirect' => route('pos.orders.index')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function orderIndex(Request $request)
    {
        $campusId = auth()->user()->campus_id ?? 1;

        $query = Order::where('campus_id', $campusId)
            ->with(['user', 'items'])
            ->latest();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        $summaryQuery = clone $query;
        $totalRevenue = $summaryQuery->sum('grand_total');
        $totalOrdersCount = $summaryQuery->count();
        $totalItemsSold = (clone $summaryQuery)->with('items')->get()->sum(function ($order) {
            return $order->items->sum('quantity');
        });
        $perPage = $this->getPerPage($request, 15);
        $orders = $query->paginate($perPage)->appends($request->query());

        return view('admin.reports.orders._orders', compact(
            'orders',
            'totalRevenue',
            'totalOrdersCount',
            'totalItemsSold'
        ));
    }

    public function printSelectedOrders(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:orders,id'
        ]);
        $campusId = auth()->user()->campus_id ?? 1;
        $orders = Order::whereIn('id', $request->ids)
            ->with(['items', 'user'])
            ->get();
        return view('admin.reports.orders.print-selected', compact('orders'));
    }
}
