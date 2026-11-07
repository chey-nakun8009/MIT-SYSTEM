<div class="row row-cols-2 row-cols-md-4 row-cols-xl-5 g-3" id="productGrid">
    @forelse ($products as $product)
        @php
            $defaultOption =
                $product->unitOptions->where('is_active', true)->where('is_default', true)->first() ??
                $product->unitOptions->where('is_active', true)->first();

            $price = $defaultOption?->price ?? 0;
            $unitId = $defaultOption?->unit_id ?? ($product->base_unit_id ?? 1);
            $unitSymbol = $defaultOption?->unit?->symbol ?? ($product->unit?->symbol ?? 'unit');
            $photoUrl = $product->primary_image_url;
        @endphp

        <div class="col product-item" data-id="{{ $product->id }}" data-name="{{ $product->name }}"
            data-price="{{ $price }}" data-unit-id="{{ $unitId }}" data-unit-symbol="{{ $unitSymbol }}"
            data-category-id="{{ $product->category_id }}" role="button">

            <div class="card h-100 product-card border shadow-sm overflow-hidden rounded-0">
                <div class="product-image-wrapper">
                    <img src="{{ $photoUrl }}" alt="{{ $product->name }}" class="product-image">
                </div>
                <div class="card-body p-2 d-flex flex-column">

                    <h6 class="text-success card-title fw-bold text-truncate mb-2" title="{{ $product->name }}">
                        {{ Str::title($product->name) }}
                    </h6>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <span class="text-danger fw-bold">
                            ${{ number_format($price, 3) }}
                        </span>
                        <small class="text-muted">
                            {{ $unitSymbol }}
                        </small>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                        <small class="">
                            <i class="bi bi-box-seam me-1"></i>ស្តុក
                        </small>
                        <small class="fw-semibold">
                            {{ $product->total_stock }}
                        </small>
                    </div>

                </div>
            </div>
        </div>

    @empty
        <div class="col-12 py-5 text-center">
            <i class="bi bi-box-seam fs-1 text-muted d-block mb-2"></i>
            <p class="text-muted mb-0">មិនមានផលិតផលក្នុងស្តុក</p>
        </div>
    @endforelse
</div>
