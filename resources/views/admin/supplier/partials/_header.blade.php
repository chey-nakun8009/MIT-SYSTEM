<div class="row g-2 g-lg-2 mb-2">
    <div class="col-xl-3 col-lg-6">
        <div class="card stats-card">
            <div class="card-body p-3 p-lg-4">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-primary bg-opacity-10 text-primary me-3">
                        <x-svg.suppliers />
                    </div>
                    <div>
                        <p class="h6 mb-0 fw-bold">Total Suppliers</p>
                        <div class="h3 mb-0"><span>{{ $suppliers->count() ?? '0' }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="card stats-card">
            <div class="card-body p-3 p-lg-4">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-success bg-opacity-10 text-success me-3">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <p class="h6 mb-0 text-success fw-bold">Active Supplier</p>
                        <div class="h3 mb-0"> <span
                                class="text-success">{{ $suppliers->where('is_active', true)->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="card stats-card">
            <div class="card-body p-3 p-lg-4">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-warning bg-opacity-10 text-warning me-3">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div>
                        <p class="h6 mb-0 fw-bold">Inactive Supplier</p>
                        <div class="h3 mb-0" aria-live="polite">
                            <span class="text-danger">{{ $suppliers->where('is_active', false)->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="card stats-card">
            <div class="card-body p-3 p-lg-4">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-info bg-opacity-10 text-info me-3">
                        <x-svg.newest />
                    </div>
                    <div>
                        <p class="h6 mb-0 text-success fw-bold">Newest Supplier</p>
                        <div class="h3 mb-0" aria-live="polite"><span class="text-success">
                                {{ $suppliers->where('created_at', '>=', now()->subDays(7))->count() }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
