@extends('admin.reports.index')
@section('settings_content')
    <div class="container-fluid px-4 py-4">
        <div class="card bg-light border-0 p-3 mb-4 rounded-0 d-print-none">
            <form method="GET" action="{{ route('orders.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">កាលបរិច្ឆេទចាប់ពី</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        class="form-control form-control-sm rounded-0">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">ដល់កាលបរិច្ឆេទ</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        class="form-control form-control-sm rounded-0">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">ស្វែងរកវិក្កយបត្រ / ទូរស័ព្ទ</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="form-control form-control-sm rounded-0" placeholder="ORD-... ឬ លេខទូរស័ព្ទ">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-xs btn-dark rounded-0 px-3">
                        <i class="bi bi-filter me-1"></i> ស្វែងរក
                    </button>
                    <a href="{{ route('orders.index') }}" class="btn btn-xs btn-outline-secondary rounded-0">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> សម្អាត
                    </a>
                </div>
            </form>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card bg-white p-3 border-0 border-start border-4 border-success shadow-sm rounded-0">
                    <span class="text-muted small text-uppercase fw-semibold">ប្រាក់ចំណូលសរុប (Total Revenue)</span>
                    <h4 class="fw-bold text-success mb-0 mt-1">${{ number_format($totalRevenue ?? 0, 2) }}</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-white p-3 border-0 border-start border-4 border-primary shadow-sm rounded-0">
                    <span class="text-muted small text-uppercase fw-semibold">ចំនួនវិក្កយបត្រសរុប (Total Orders)</span>
                    <h4 class="fw-bold text-primary mb-0 mt-1">{{ $totalOrdersCount ?? $orders->total() }}</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-white p-3 border-0 border-start border-4 border-secondary shadow-sm rounded-0">
                    <span class="text-muted small text-uppercase fw-semibold">ទំនិញលក់បានសរុប (Items Sold)</span>
                    <h4 class="fw-bold text-dark mb-0 mt-1">{{ $totalItemsSold ?? 0 }}</h4>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-receipt-cutoff me-2"></i>បញ្ជីបញ្ជាទិញ</h5>
            <x-per-page-selector :route="route('orders.index')" />
        </div>
        <form action="{{ route('pos.orders.print-selected') ?? '#' }}" method="POST" target="_blank" id="printSelectedForm"
            onsubmit="return validatePrintSelection(event)">
            @csrf
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input rounded-0" type="checkbox" id="selectAll">
                    <label class="form-check-label small fw-bold text-muted" for="selectAll">ជ្រើសរើសទាំងអស់</label>
                </div>
                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-xs btn-secondary rounded-0">
                        <i class="bi bi-printer me-1"></i> បោះពុម្ព
                    </button>
                </div>
            </div>

            <div class="table-responsive bg-white shadow-sm border">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40px;" class="txt-center">#</th>
                            <th style="width: 50px !important;" class="text-center">ល.រ</th>
                            <th class="txt-start">លេខវិក្កយបត្រ</th>
                            <th class="txt-start">អតិថិជន</th>
                            <th class="txt-center">ចំនួនមុខទំនិញ</th>
                            <th class="txt-center">កាលបរិច្ឆេទ</th>
                            <th class="txt-center">ស្ថានភាព</th>
                            <th class="txt-center">ទឹកប្រាក់សរុប</th>
                            <th class="txt-center" style="width: 120px;">គ្រប់គ្រង</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $index => $order)
                            <tr data-id="{{ $order->id }}">
                                <td class="txt-center">
                                    <input class="form-check-input row-checkbox rounded-0" type="checkbox" name="ids[]"
                                        value="{{ $order->id }}">
                                </td>
                                <td class="txt-center" style="width: 50px !important;">{{ $orders->firstItem() + $index }}
                                </td>
                                <td>
                                    <span class="fw-bold text-primary">{{ $order->order_number }}</span>
                                </td>
                                <td class="txt-start">
                                    {{ $order->customer_phone ?? 'អតិថិជនទូទៅ (Walk-in)' }}
                                </td>
                                <td class="txt-center">
                                    <span class="badge bg-secondary rounded-pill">{{ $order->items->sum('quantity') }}
                                        items</span>
                                </td>
                                <td class="txt-center text-muted small" style="width: 160px !important;">
                                    {{ $order->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td class="txt-center">
                                    @if ($order->status === 'completed')
                                        <span class="badge bg-success">បានទូទាត់</span>
                                    @else
                                        <span class="badge bg-warning text-dark">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                                <td class="txt-center fw-semibold text-success">
                                    ${{ number_format($order->grand_total, 2) }}
                                </td>
                                <td class="txt-center">
                                    <div class="d-flex align-items-center gap-1">
                                        <a href="{{ route('pos.receipt', $order->id) }}"
                                            class="btn btn-sm btn-action action-edit" title="Print Order">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-action action-delete btn-delete"
                                            data-url="{{ route('api.pos.order.destroy', $order->id) }}" title="Delete">
                                            <x-svg.trash />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <x-empty-row :colspan="9" />
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        @if ($orders->hasPages())
            <div class="d-flex justify-content-end mt-2">
                {{ $orders->links('vendor.pagination.bootstrap-5') }}
            </div>
        @endif
    </div>

    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.row-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        function validatePrintSelection(event) {
            let checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
            if (checkedBoxes.length === 0) {
                alert('សូមជ្រើសរើសវិក្កយបត្រយ៉ាងតិច១ ដើម្បីបោះពុម្ព។');
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
@endsection
