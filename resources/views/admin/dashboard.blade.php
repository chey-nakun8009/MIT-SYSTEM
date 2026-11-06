<x-admin-layout>
    <div class="row g-3 g-lg-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card stats-card border-0 shadow-sm rounded-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-success bg-opacity-10 text-success p-3 rounded-0">
                                <i class="bi bi-graph-up-arrow fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0 text-success fw-semibold">ចំណូលសរុប</h3>
                            <h4 class="mb-0 fw-bold text-success">${{ number_format($totalRevenue ?? 0, 3) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stats-card border-0 shadow-sm rounded-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-danger bg-opacity-10 text-danger p-3 rounded-0">
                                <i class="bi bi-wallet2"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0 text-danger fw-semibold">ចំណាយសរុប</h3>
                            <h4 class="mb-0 fw-bold text-danger">${{ number_format($totalExpenses ?? 0, 3) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stats-card border-0 shadow-sm rounded-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-primary bg-opacity-10 text-primary p-3 rounded-0">
                                <i class="bi bi-box"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0 text-muted fw-semibold">ផលិតផលសរុប</h3>
                            <h4 class="mb-0 fw-bold">{{ number_format($totalProducts ?? 0) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stats-card border-0 shadow-sm rounded-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-info bg-opacity-10 text-info p-3 rounded-0">
                                <i class="bi bi-people fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0 text-muted fw-semibold">អ្នកប្រើប្រាស់</h3>
                            <h4 class="mb-0 fw-bold">{{ number_format($totalUsers ?? 0) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-0 h-100">
                <div class="card-header bg-white py-3">
                    <h2 class="h5 card-title mb-0 fw-bold text-dark">ប្រតិបត្តិការស្តុកថ្មីៗ</h2>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="txt-center">ល.រ</th>
                                    <th class="txt-start">ផលិតផល</th>
                                    <th class="txt-center">ចំនួន</th>
                                    <th class="txt-center">ថ្លៃដើម</th>
                                    <th>កាលបរិច្ឆេទ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTransactions ?? [] as $index => $tx)
                                    <tr>
                                        <td class="txt-center">{{ $index + 1 }}</td>
                                        <td>{{ optional($tx->product)->name ?? 'N/A' }}</td>
                                        <td class="txt-center fw-semibold">{{ number_format($tx->quantity, 3) }}</td>
                                        <td class="txt-center text-danger">${{ number_format($tx->cost_price, 3) }}
                                        </td>
                                        <td class="txt-center" style="width: 100px;">
                                            {{ $tx->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @empty
                                    <x-empty-row :colspan="5" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-0 h-100">
                <div class="card-header bg-white py-3">
                    <h2 class="h5 card-title mb-0 fw-bold text-dark">ចំណាយថ្មីៗ</h2>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ប្រភេទ</th>
                                    <th class="txt-center">ទឹកប្រាក់</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentExpenses ?? [] as $exp)
                                    <tr>
                                        <td>
                                            <strong>{{ optional($exp->category)->name ?? 'General' }}</strong>
                                            <br><small class="text-muted">{{ Str::limit($exp->note, 25) }}</small>
                                        </td>
                                        <td class="txt-center fw-semibold text-danger">
                                            -${{ number_format($exp->amount, 3) }}
                                        </td>
                                    </tr>
                                @empty
                                    <x-empty-row :colspan="2" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-0">
                <div class="card-header bg-white py-3">
                    <h2 class="h5 card-title mb-0 fw-bold text-dark">ចំណូលថ្មីៗ</h2>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 50px;">ល.រ</th>
                                    <th class="txt-start">វិក្កយបត្រ</th>
                                    <th class="txt-start">ប្រភេទចំណូល</th>
                                    <th class="txt-start">កំណត់ចំណាំ</th>
                                    <th class="txt-center">កាលបរិច្ឆេទ</th>
                                    <th class="txt-center">ទឹកប្រាក់</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentRevenues ?? [] as $index => $rev)
                                    <tr>
                                        <td class="txt-center">{{ $index + 1 }}</td>
                                        <td class="txt-start">{{ $rev->reference_no ?? 'N/A' }}</td>
                                        <td>{{ optional($rev->category)->name ?? 'General' }}</td>
                                        <td class="txt-start">{{ Str::limit($rev->note, 50) }}</td>
                                        <td class="txt-center">{{ $rev->created_at->format('Y-m-d') }}</td>
                                        <td class="txt-center fw-semibold text-success">
                                            +${{ number_format($rev->amount, 3) }}
                                        </td>
                                    </tr>
                                @empty
                                    <x-empty-row :colspan="6" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
