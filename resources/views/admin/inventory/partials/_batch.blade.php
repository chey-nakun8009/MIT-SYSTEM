@if ($isBatch)
    <tr>
        <td colspan="8" class="p-0 bg-light">
            <div class="collapse" id="{{ $collapseId }}">
                <div class="p-3">
                    <h6 class="fw-bold text-secondary mb-2 small">
                        <i class="bi bi-box-seam me-1"></i> បញ្ជីផលិតផលក្នុងវិក្កយបត្របាច់លេខ:
                        {{ $firstTx->reference_no }}
                    </h6>
                    <table class="table table-sm table-bordered bg-white mb-0 align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th class="txt-start">ផលិតផល</th>
                                <th class="txt-center">ចំនួនទទួល</th>
                                <th class="txt-center">បម្លែងមូលដ្ឋាន</th>
                                <th class="txt-center">ថ្លៃដើម</th>
                                <th class="txt-center">ទឹកប្រាក់សរុប</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($group as $bItem)
                                @php
                                    $itemTotal = ($bItem->quantity ?? 0) * ($bItem->cost_price ?? 0);
                                @endphp
                                <tr>
                                    <td class="txt-start">
                                        <span
                                            class="fw-semibold text-success">{{ $bItem->product->name ?? 'Deleted' }}</span>
                                        <small class="text-muted">({{ $bItem->product->sku ?? 'N/A' }})</small>
                                    </td>
                                    <td class="txt-center">
                                        <span>
                                            {{ number_format($bItem->quantity, 0) }}
                                            {{ $bItem->unit->name ?? '' }}
                                        </span>
                                    </td>
                                    <td class="txt-center">
                                        <span>
                                            +{{ number_format($bItem->base_quantity, 0) }}
                                            {{ $bItem->product->baseUnit->symbol ?? '' }}
                                        </span>
                                    </td>
                                    <td class="txt-center">
                                        {{ $bItem->cost_price ? '$' . number_format($bItem->cost_price, 3) : '-' }}
                                    </td>
                                    <td class="txt-center fw-semibold text-success">
                                        {{ $itemTotal > 0 ? '$' . number_format($itemTotal, 3) : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </td>
    </tr>
@endif
