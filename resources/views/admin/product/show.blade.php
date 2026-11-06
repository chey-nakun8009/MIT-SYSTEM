<x-admin-layout>
    <div class="container-fluid px-4 py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">ព័ត៌មានលម្អិតផលិតផល</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">ផលិតផល</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary rounded-0">
                    <i class="bi bi-pencil-square me-1"></i> កែប្រែ
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary rounded-0">
                    <i class="bi bi-arrow-left me-1"></i> ត្រឡប់ក្រោយ
                </a>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-0 mb-3">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-info-circle me-2"></i> ព័ត៌មានទូទៅ
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <span class="text-muted d-block small">ឈ្មោះផលិតផល</span>
                                <h5 class="fw-bold text-dark">{{ $product->name }}</h5>
                            </div>
                            <div class="col-md-6">
                                <span class="text-muted d-block small">លេខកូដ (SKU)</span>
                                <span
                                    class="badge bg-light text-dark border px-2 py-1 font-monospace">{{ $product->sku }}</span>
                            </div>
                            <div class="col-md-4">
                                <span class="text-muted d-block small">ប្រភេទ</span>
                                <span class="fw-semibold">{{ $product->category->name ?? 'ទូទៅ' }}</span>
                            </div>
                            <div class="col-md-4">
                                <span class="text-muted d-block small">ម៉ាក់យីហោ</span>
                                <span class="fw-semibold">{{ $product->brand->name ?? 'ទូទៅ' }}</span>
                            </div>
                            <div class="col-md-4">
                                <span class="text-muted d-block small">ឯកតាមូលដ្ឋាន</span>
                                <span class="fw-semibold">{{ $product->baseUnit->name ?? 'ទូទៅ' }}
                                    ({{ $product->baseUnit->symbol ?? '' }})</span>
                            </div>
                            <div class="col-md-4">
                                <span class="text-muted d-block small">ប្រភេទផលិតផល</span>
                                <span class="text-capitalize">{{ $product->type }}</span>
                            </div>
                            <div class="col-md-4">
                                <span class="text-muted d-block small">ស្ថានភាព</span>
                                @if ($product->is_active)
                                    <span class="text-success">សកម្ម</span>
                                @else
                                    <span class="text-danger">អសកម្ម</span>
                                @endif
                            </div>
                            <div class="col-12">
                                <span class="text-muted d-block small">បរិយាយ</span>
                                <p class="mb-0 text-secondary">
                                    {{ $product->description ?: 'គ្មានការបរិយាយ' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm rounded-0 mb-3">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-rulers me-2"></i> ឯកតាលក់និងតម្លៃ
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="txt-start">ឯកតា</th>
                                        <th>ចំនួនបម្លែង</th>
                                        <th>តម្លៃលក់</th>
                                        <th class="text-center">ឯកតាដើម</th>
                                        <th class="text-center">ស្ថានភាព</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($product->unitOptions as $option)
                                        <tr>
                                            <td class="fw-semibold">
                                                {{ $option->unit->name ?? '' }}
                                                @if ($option->unit->symbol)
                                                    <span class="text-muted">({{ $option->unit->symbol }})</span>
                                                @endif
                                            </td>
                                            <td class="txt-center">{{ number_format($option->conversion_factor, 4) }}
                                            </td>
                                            <td class="text-success fw-bold txt-center">
                                                ${{ number_format($option->price, 3) }}
                                            </td>
                                            <td class="txt-center">
                                                @if ($option->is_default)
                                                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                                @else
                                                    <i class="bi bi-x-lg text-danger"></i>
                                                @endif
                                            </td>
                                            <td class="txt-center">
                                                @if ($option->is_active)
                                                    <span
                                                        class="badge bg-success-subtle text-success rounded-0">សកម្ម</span>
                                                @else
                                                    <span
                                                        class="badge bg-danger-subtle text-danger rounded-0">អសកម្ម</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-3">
                                                មិនមានកំណត់ឯកតាលក់បន្ថែម
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm rounded-0 mb-3">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-box-seam me-2"></i> ស្តុកក្នុងឃ្លាំង
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">បរិមាណស្តុកសរុប</span>
                            <span class="fs-5 fw-bold text-dark">
                                {{ number_format($product->inventory->quantity ?? 0, 0) }}
                                <span class="text-muted fs-6">{{ $product->baseUnit->name ?? '' }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-0 mb-3">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-image me-2"></i> រូបភាពផលិតផល
                        </h6>
                    </div>
                    <div class="card-body text-center p-3">
                        <div class="border bg-light d-flex align-items-center justify-content-center p-2"
                            style="height: 260px; overflow: hidden;">
                            <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" class="img-fluid"
                                style="max-height: 100%; object-fit: contain;">
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm rounded-0 mb-3">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0 text-secondary">
                            <i class="bi bi-clock-history me-2"></i> កាលបរិច្ឆេទប្រព័ន្ធ
                        </h6>
                    </div>
                    <div class="card-body p-3 small">
                        <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
                            <span class="text-muted">បង្កើតកាលពី</span>
                            <span class="fw-semibold">{{ $product->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">កែប្រែចុងក្រោយ:</span>
                            <span class="fw-semibold">{{ $product->updated_at->format('d M Y, h:i A') }}</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-admin-layout>
