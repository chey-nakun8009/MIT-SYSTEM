<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th style="width: 60px;" class="text-center">ល.រ</th>
                <th>កាលបរិច្ឆេទ</th>
                <th>ផលិតផល</th>
                <th>ចំនួនទទួល</th>
                <th>បរិមាណបម្លែងមូលដ្ឋាន</th>
                <th>ថ្លៃដើម</th>
                <th>លេខយោង</th>
                <th>អ្នកបញ្ចូល</th>
                <th>កំណត់</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $tx)
                <tr data-id="{{ $tx->id }}">
                    <td class="txt-center">{{ $transactions->firstItem() + $index }}</td>
                    <td class="txt-center">
                        <span class="d-block fw-semibold">{{ $tx->created_at->format('d M Y') }}</span>
                        <small class="text-muted">{{ $tx->created_at->format('h:i A') }}</small>
                    </td>
                    <td>
                        <span class="fw-bold text-dark d-block">{{ $tx->product->name ?? 'Deleted' }}</span>
                        <small class="text-muted font-monospace">SKU: {{ $tx->product->sku ?? 'ទូទៅ' }}</small>
                    </td>
                    <td class="text-success fw-bold txt-center">
                        {{ number_format($tx->quantity, 0) }} {{ $tx->unit->name ?? '' }}
                    </td>
                    <td class="txt-center">
                        <span class="fw-semibold text-primary">
                            +{{ number_format($tx->base_quantity, 0) }}
                            <small>{{ $tx->product->baseUnit->symbol ?? '' }}</small>
                        </span>
                    </td>
                    <td class="txt-center fw-semibold text-primary">
                        @if ($tx->cost_price)
                            <span class="text-dark">${{ number_format($tx->cost_price, 3) }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="txt-center fw-semibold text-primary">{{ $tx->reference_no ?: 'N/A' }}
                    </td>
                    <td class="txt-center fw-semibold text-primary">
                        <span class="small text-muted"><i
                                class="bi bi-person me-1"></i>{{ $tx->user->name ?? 'System' }}</span>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center align-items-center gap-1">
                            @php
                                // Check if this reference_no is shared by multiple transaction rows (Bulk vs Single)
                                $isBatch =
                                    $tx->reference_no &&
                                    \App\Models\InventoryTransaction::where('campus_id', auth()->user()->campus_id)
                                        ->where('reference_no', $tx->reference_no)
                                        ->count() > 1;
                            @endphp

                            {{-- Route to Batch Edit if it's a multi-item import, otherwise Route to Single Edit --}}
                            <a href="{{ $isBatch ? route('inventory-transactions.edit-multiple', ['reference_no' => $tx->reference_no]) : route('inventory-transactions.edit', $tx->id) }}"
                                class="btn btn-sm btn-action action-edit"
                                title="{{ $isBatch ? 'Edit Batch Import' : 'Edit Transaction' }}">
                                <x-svg.edit />
                            </a>

                            {{-- Delete Button --}}
                            <button type="button" class="btn btn-sm btn-action action-delete btn-delete"
                                data-url="{{ route('inventory-transactions.destroy', $tx->id) }}"
                                title="Delete Transaction">
                                <x-svg.trash />
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr class="txt-center">
                    <td colspan="9" class="txt-center text-muted py-4">
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
