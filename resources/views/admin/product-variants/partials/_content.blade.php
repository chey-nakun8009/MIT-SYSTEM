<div class="card border-0 shadow-sm rounded-0">
    <div class="card-body">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">

            <div>
                <h5 class="mb-1 fw-semibold">
                    Product Variants
                </h5>

                <p class="text-muted mb-0 small">
                    Manage product variations, SKU and pricing.
                </p>
            </div>

            <a href="{{ route('product-variants.create') }}" class="btn btn-sm rounded-0"
                style="background-color:#6f4e37;color:#fff;">
                <i class="bi bi-plus-lg me-1"></i>
                Add Variant
            </a>

        </div>

        <div class="row g-2 mb-3">

            <div class="col-lg-6 col-md-6">
                <div class="input-group input-group-sm">

                    <span class="input-group-text bg-white rounded-0">
                        <i class="bi bi-search"></i>
                    </span>

                    <input type="text" id="variant-search" class="form-control rounded-0"
                        placeholder="Search SKU or product...">

                </div>
            </div>

            <div class="col-lg-3 col-md-3">

                <select id="variant-product" class="form-select form-select-sm rounded-0">

                    <option value="">
                        All Products
                    </option>

                    @foreach ($products ?? [] as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->name }}
                        </option>
                    @endforeach

                </select>

            </div>

            <div class="col-lg-3 col-md-3">

                <select id="variant-status" class="form-select form-select-sm rounded-0">

                    <option value="">
                        All Status
                    </option>

                    <option value="1">
                        Active
                    </option>

                    <option value="0">
                        Inactive
                    </option>

                </select>

            </div>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th>SKU</th>
                        <th>Product</th>
                        <th>Attributes</th>
                        <th class="text-end">Price</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse ($variants ?? [] as $variant)

                        <tr data-id="{{ $variant->id }}">

                            <td>
                                <span class="fw-semibold">
                                    {{ $variant->sku }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('products.show', $variant->product_id) }}"
                                    class="text-decoration-none" style="color:#6f4e37;">

                                    {{ $variant->product?->name ?? '-' }}

                                </a>
                            </td>

                            <td>

                                @php
                                    $attributes = is_array($variant->attributes)
                                        ? $variant->attributes
                                        : json_decode($variant->attributes ?? '{}', true);
                                @endphp

                                <div class="d-flex flex-wrap gap-1">

                                    @forelse ($attributes ?? [] as $key => $value)
                                        <span class="badge bg-light text-dark border rounded-0">
                                            {{ ucfirst($key) }}:
                                            {{ $value }}
                                        </span>

                                    @empty

                                        <span class="text-muted">
                                            -
                                        </span>
                                    @endforelse

                                </div>

                            </td>

                            <td class="text-end">
                                {{ number_format($variant->price, 3) }}
                            </td>

                            <td>

                                @if ($variant->is_active)
                                    <span class="badge bg-success-subtle text-success rounded-0">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger rounded-0">
                                        Inactive
                                    </span>
                                @endif

                            </td>

                            <td>

                                <div class="d-flex justify-content-end gap-1">

                                    <a href="{{ route('product-variants.edit', [
                                        'product_variant' => $variant->id,
                                    ]) }}"
                                        class="btn btn-sm btn-action btn-edit" title="Edit">

                                        <i class="bi bi-pencil"></i>

                                    </a>

                                    <button type="button" class="btn btn-sm btn-action btn-delete delete-item"
                                        data-url="{{ route('product-variants.destroy', $variant->id) }}"
                                        title="Delete">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6">

                                <div class="text-center py-5">

                                    <i class="bi bi-diagram-3 fs-1 text-muted"></i>

                                    <h6 class="mt-3">
                                        No variants found
                                    </h6>

                                    <p class="text-muted small mb-3">
                                        Create your first product variant.
                                    </p>

                                    <a href="{{ route('product-variants.create') }}" class="btn btn-sm rounded-0"
                                        style="background-color:#6f4e37;color:#fff;">

                                        <i class="bi bi-plus-lg me-1"></i>
                                        Add Variant

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if (isset($variants) && $variants->hasPages())
            <div class="mt-3">
                {{ $variants->links() }}
            </div>
        @endif

    </div>
</div>
