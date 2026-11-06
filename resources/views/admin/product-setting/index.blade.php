<x-admin-layout>
    @include('admin.product.partials._tabs')
    <div class="card border-0 shadow-sm rounded-0">

        <div class="card-body">

            <div class="mb-4">
                <h5 class="mb-1 fw-semibold">
                    Product Settings
                </h5>

                <p class="text-muted mb-0 small">
                    Configure how products work in your store.
                </p>
            </div>

            <form action="{{ route('products.settings.update') }}" method="POST" class="ajax-form">

                @csrf
                @method('PUT')

                {{-- General --}}
                <div class="mb-4">

                    <h6 class="fw-semibold mb-3">
                        <i class="bi bi-gear me-1" style="color:#6f4e37;"></i>

                        General
                    </h6>

                    <div class="border p-3 rounded-0">

                        <div class="row g-3">

                            <div class="col-md-6">

                                <label class="form-label">
                                    SKU Prefix
                                </label>

                                <input type="text" name="sku_prefix" class="form-control rounded-0"
                                    value="{{ $settings->sku_prefix ?? 'PRD' }}" maxlength="20">

                                <div class="form-text">
                                    Example: PRD-000001
                                </div>

                            </div>

                            <div class="col-md-6">

                                <label class="form-label">
                                    Decimal Places
                                </label>

                                <select name="decimal_places" class="form-select rounded-0">

                                    @for ($i = 0; $i <= 6; $i++)
                                        <option value="{{ $i }}" @selected(($settings->decimal_places ?? 3) == $i)>
                                            {{ $i }}
                                        </option>
                                    @endfor

                                </select>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Product --}}
                <div class="mb-4">

                    <h6 class="fw-semibold mb-3">
                        <i class="bi bi-box-seam me-1" style="color:#6f4e37;"></i>

                        Product
                    </h6>

                    <div class="border p-3 rounded-0">

                        <div class="row g-3">

                            <div class="col-md-6">

                                <label class="form-label">
                                    Default Product Status
                                </label>

                                <select name="default_status" class="form-select rounded-0">

                                    <option value="1" @selected(($settings->default_status ?? 1) == 1)>
                                        Active
                                    </option>

                                    <option value="0" @selected(($settings->default_status ?? 1) == 0)>
                                        Inactive
                                    </option>

                                </select>

                            </div>

                            <div class="col-md-6">

                                <label class="form-label">
                                    Allow Product Without Image
                                </label>

                                <div class="form-check form-switch mt-2">

                                    <input type="hidden" name="allow_without_image" value="0">

                                    <input type="checkbox" name="allow_without_image" value="1"
                                        class="form-check-input" @checked($settings->allow_without_image ?? true)>

                                    <label class="form-check-label">
                                        Allow products without an image
                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Inventory --}}
                <div class="mb-4">

                    <h6 class="fw-semibold mb-3">
                        <i class="bi bi-boxes me-1" style="color:#6f4e37;"></i>

                        Inventory
                    </h6>

                    <div class="border p-3 rounded-0">

                        <div class="form-check form-switch mb-3">

                            <input type="hidden" name="stock_tracking" value="0">

                            <input type="checkbox" name="stock_tracking" value="1" class="form-check-input"
                                @checked($settings->stock_tracking ?? true)>

                            <label class="form-check-label fw-medium">
                                Enable stock tracking
                            </label>

                            <div class="form-text">
                                Track inventory quantity for products.
                            </div>

                        </div>

                        <div class="form-check form-switch mb-3">

                            <input type="hidden" name="allow_negative_stock" value="0">

                            <input type="checkbox" name="allow_negative_stock" value="1" class="form-check-input"
                                @checked($settings->allow_negative_stock ?? false)>

                            <label class="form-check-label fw-medium">
                                Allow negative stock
                            </label>

                        </div>

                        <div class="form-check form-switch">

                            <input type="hidden" name="stock_warning" value="0">

                            <input type="checkbox" name="stock_warning" value="1" class="form-check-input"
                                @checked($settings->stock_warning ?? true)>

                            <label class="form-check-label fw-medium">
                                Show stock warning
                            </label>

                        </div>

                    </div>

                </div>

                {{-- Save --}}
                <div class="d-flex justify-content-end">

                    <button type="submit" class="btn rounded-0" style="background-color:#6f4e37;color:#fff;">

                        <i class="bi bi-check-lg me-1"></i>
                        Save Changes

                    </button>

                </div>

            </form>

        </div>
    </div>
    
    <div id="product-content">
        @include('admin.product.partials._content')
    </div>
</x-admin-layout>
