<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th style="width: 80px;" class="txt-center">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <input type="checkbox" id="selectAll" class="form-check-input">
                        <span>ល.រ</span>
                    </div>
                </th>
                </th>
                <th class="txt-center">កាលបរិច្ឆេទ</th>
                <th class="txt-start">ផលិតផល</th>
                <th class="txt-center">ចំនួនទទួល</th>
                <th class="txt-center">បរិមាណបម្លែងមូលដ្ឋាន</th>
                <th class="txt-center">ថ្លៃដើម / ទឹកប្រាក់សរុบ</th>
                <th class="txt-center">លេខយោង</th>
                <th class="txt-center" style="width: 130px !important;">កំណត់</th>
            </tr>
        </thead>
        <tbody>
            @php
                $groupedTransactions = $transactions->groupBy(function ($tx) {
                    return $tx->reference_no &&
                        \App\Models\InventoryTransaction::where('campus_id', auth()->user()->campus_id)
                            ->where('reference_no', $tx->reference_no)
                            ->count() > 1
                        ? 'batch_' . $tx->reference_no
                        : 'single_' . $tx->id;
                });
                $rowNumber = 1;
            @endphp

            @forelse($groupedTransactions as $groupKey => $group)
                @php
                    $isBatch = str_starts_with($groupKey, 'batch_');
                    $firstTx = $group->first();
                    $collapseId = 'batchCollapse_' . ($isBatch ? md5($firstTx->reference_no) : $firstTx->id);
                    $totalAmount = $group->sum(function ($item) {
                        return ($item->quantity ?? 0) * ($item->cost_price ?? 0);
                    });
                    $totalBaseQty = $group->sum('base_quantity');
                @endphp

                <tr data-id="{{ $firstTx->id }}">
                    <td class="txt-center">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <input type="checkbox" name="ids[]" value="{{ $firstTx->id }}"
                                class="form-check-input transaction-checkbox">
                            <span>{{ $rowNumber++ }}</span>
                        </div>
                    </td>
                    <td class="txt-center">
                        {{ $firstTx->created_at->format('d M Y') }}
                    </td>
                    <td class="txt-start fw-bold">
                        @if ($isBatch)
                            <span class="text-success d-block">
                                <i class="bi bi-collection me-1"></i> នាំចូលច្រើនមុខ:
                                {{ $group->count() }} មុខទំនិញ
                            </span>
                        @else
                            <span class="fw-bold d-block text-success">{{ $firstTx->product->name ?? 'Deleted' }}</span>
                            <small class="text-muted font-monospace">SKU: {{ $firstTx->product->sku ?? 'ទូទៅ' }}</small>
                        @endif
                    </td>
                    <td class="txt-center">
                        @if ($isBatch)
                            <span>បាច់សរុប ({{ $group->count() }} មុខ)</span>
                        @else
                            {{ number_format($firstTx->quantity, 0) }} {{ $firstTx->unit->name ?? '' }}
                        @endif
                    </td>
                    <td class="txt-center">
                        <span>
                            +{{ number_format($isBatch ? $totalBaseQty : $firstTx->base_quantity, 0) }}
                            <small>{{ $firstTx->product->baseUnit->symbol ?? '' }}</small>
                        </span>
                    </td>
                    <td class="txt-center">
                        @if (!$isBatch && $firstTx->cost_price)
                            <span
                                class="d-block">ថ្លៃ:${{ number_format($firstTx->cost_price, 3) }}/{{ $firstTx->unit->name ?? '' }}</span>
                            <span class="small">សរុប:
                                ${{ number_format(($firstTx->quantity ?? 0) * ($firstTx->cost_price ?? 0), 3) }}</span>
                        @elseif ($isBatch)
                            <span class="">តម្លៃ:
                                ${{ number_format($totalAmount, 3) }}/{{ $firstTx->unit->name ?? '' }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="txt-center">
                        {{ $firstTx->reference_no ?: 'គ្មាន' }}
                    </td>
                    <td class="txt-center" style="width: 130px !important;">
                        <div class="d-flex justify-content-center align-items-center gap-1">
                            @if ($isBatch)
                                <button class="btn btn-sm rounded-0 px-2 py-1" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#{{ $collapseId }}" aria-expanded="false"
                                    aria-controls="{{ $collapseId }}" title="បង្ហាញមុខទំនិញក្នុងបាច់">
                                    <i class="bi bi-chevron-down fw-bold"></i>
                                </button>
                                <a href="{{ route('inventory-transactions.edit-multiple', ['reference_no' => $firstTx->reference_no]) }}"
                                    class="btn btn-sm btn-action action-edit" title="Edit Batch Import">
                                    <x-svg.edit />
                                </a>
                            @else
                                <a href="{{ route('inventory-transactions.edit', $firstTx->id) }}"
                                    class="btn btn-sm btn-action action-edit" title="Edit Transaction">
                                    <x-svg.edit />
                                </a>
                            @endif

                            <button type="button" class="btn btn-sm btn-action action-delete btn-delete"
                                data-url="{{ route('inventory-transactions.destroy', $firstTx->id) }}"
                                title="Delete Transaction">
                                <x-svg.trash />
                            </button>
                            <a href="{{ route('inventory-transactions.print-report', $firstTx->reference_no) }}"
                                target="_blank" class="btn btn-sm btn-action action-edit">
                                <i class="bi bi-printer"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @include('admin.inventory.partials._batch')
            @empty
                <tr class="txt-center">
                    <td colspan="8" class="txt-center text-muted py-4">
                        <i class="bi bi-folder2-open display-6 d-block mb-2"></i>
                        មិនមានប្រតិបត្តិការស្តុកនៅឡើយទេ
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if (isset($transactions) && $transactions->hasPages())
    <div class="card-footer bg-white py-3">
        {{ $transactions->links() }}
    </div>
@endif
