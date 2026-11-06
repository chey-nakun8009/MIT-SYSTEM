<div class="card border-0 shadow-sm rounded-0">
    <div class="card-body">

        {{-- Header --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div>
                <h5 class="mb-1 fw-semibold">Products</h5>
                <p class="text-muted mb-0 small">
                    Manage your products and product information.
                </p>
            </div>

            <a href="{{ route('products.create') }}" class="btn btn-sm rounded-0"
                style="background-color:#6f4e37;color:#fff;">
                <i class="bi bi-plus-lg me-1"></i>
                Add Product
            </a>
        </div>

        {{-- Filters --}}
        <div class="row g-2 mb-3">

            <div class="col-lg-5 col-md-6">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white rounded-0">
                        <i class="bi bi-search"></i>
                    </span>

                    <input type="text" class="form-control rounded-0" id="product-search"
                        placeholder="Search product or SKU...">
                </div>
            </div>

            <div class="col-lg-2 col-md-3">
                <select class="form-select form-select-sm rounded-0" id="product-category">
                    <option value="">All Categories</option>

                    @foreach ($categories ?? [] as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-2 col-md-3">
                <select class="form-select form-select-sm rounded-0" id="product-type">
                    <option value="">All Types</option>
                    <option value="standard">Standard</option>
                    <option value="glass">Glass</option>
                </select>
            </div>

            <div class="col-lg-2 col-md-3">
                <select class="form-select form-select-sm rounded-0" id="product-status">
                    <option value="">All Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th style="width:70px;">Image</th>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th class="text-end" style="width:120px;">
                            Action
                        </th>
                    </tr>
                </thead>

                <tbody id="product-table-body">

                    @forelse ($products ?? [] as $product)
                        @php
                            $primaryImage = $product->images->where('is_primary', true)->first();
                        @endphp

                        <tr data-id="{{ $product->id }}">

                            {{-- Image --}}
                            <td>
                                <a href="{{ route('products.show', $product->id) }}">
                                    @if ($primaryImage)
                                        <img src="{{ asset('storage/uploads/products/' . $primaryImage->image) }}"
                                            alt="{{ $product->name }}" width="48" height="48"
                                            class="rounded-0 border" style="object-fit:cover;">
                                    @else
                                        <div class="border d-flex align-items-center justify-content-center rounded-0"
                                            style="width:48px;height:48px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </a>
                            </td>

                            {{-- Product --}}
                            <td>
                                <a href="{{ route('products.show', $product->id) }}"
                                    class="text-decoration-none fw-semibold" style="color:#6f4e37;">
                                    {{ $product->name }}
                                </a>

                                @if ($product->brand)
                                    <div class="small text-muted">
                                        {{ $product->brand->name }}
                                    </div>
                                @endif
                            </td>

                            {{-- SKU --}}
                            <td>
                                <span class="text-muted">
                                    {{ $product->sku }}
                                </span>
                            </td>

                            {{-- Category --}}
                            <td>
                                {{ $product->category?->name ?? '-' }}
                            </td>

                            {{-- Type --}}
                            <td>
                                @if ($product->type === 'glass')
                                    <span class="badge bg-info-subtle text-info rounded-0">
                                        Glass
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary rounded-0">
                                        Standard
                                    </span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td>
                                @if ($product->is_active)
                                    <span class="badge bg-success-subtle text-success rounded-0">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger rounded-0">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div class="d-flex justify-content-end gap-1">

                                    <a href="{{ route('products.show', [
                                        'product' => $product->id,
                                        'page' => $products->currentPage() ?? 1,
                                    ]) }}"
                                        class="btn btn-sm btn-action btn-view" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('products.edit', [
                                        'product' => $product->id,
                                        'page' => $products->currentPage() ?? 1,
                                    ]) }}"
                                        class="btn btn-sm btn-action btn-edit" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <button type="button" class="btn btn-sm btn-action btn-delete delete-item"
                                        data-url="{{ route('products.destroy', $product->id) }}"
                                        data-page="{{ $products->currentPage() ?? 1 }}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7">
                                <div class="text-center py-5">

                                    <i class="bi bi-box-seam fs-1 text-muted"></i>

                                    <h6 class="mt-3 mb-1">
                                        No products found
                                    </h6>

                                    <p class="text-muted small mb-3">
                                        Start by creating your first product.
                                    </p>

                                    <a href="{{ route('products.create') }}" class="btn btn-sm rounded-0"
                                        style="background-color:#6f4e37;color:#fff;">
                                        <i class="bi bi-plus-lg me-1"></i>
                                        Add Product
                                    </a>

                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

        {{-- Pagination --}}
        @if (isset($products) && $products->hasPages())
            <div class="mt-3">
                {{ $products->links() }}
            </div>
        @endif

    </div>
</div>
