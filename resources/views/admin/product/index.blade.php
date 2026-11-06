<x-admin-layout>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">{{ __('product.products') }}</h4>
            <p class="text-muted mb-0">
                {{ __('product.manage_products') }}
            </p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary rounded-0">
            <i class="bi bi-plus-lg me-1"></i>
            {{ __('product.add_product') }}
        </a>
    </div>
    <div class="card border-0 shadow-sm rounded-0">
        <div class="card-header bg-white border-bottom py-3">
            <div class="row align-items-center g-2">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white rounded-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="productSearch" class="form-control rounded-0"
                            placeholder="{{ __('product.search_placeholder') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select id="productStatus" class="form-select rounded-0">
                        <option value="">
                            {{ __('product.all_status') }}
                        </option>
                        <option value="1">
                            {{ __('product.active') }}
                        </option>
                        <option value="0">
                            {{ __('product.inactive') }}
                        </option>
                    </select>
                </div>

            </div>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th style="width: 70px;">
                                {{ __('product.image') }}
                            </th>
                            <th class="txt-start">
                                {{ __('product.name') }}
                            </th>
                            <th class="txt-start">
                                {{ __('product.sku') }}
                            </th>
                            <th class="txt-start">
                                {{ __('product.category') }}
                            </th>
                            <th class="txt-start">
                                {{ __('product.brand') }}
                            </th>

                            <th>
                                {{ __('product.type') }}
                            </th>

                            <th class="text-center">
                                {{ __('product.status') }}
                            </th>
                            <th class="text-center">
                                ស្តុកក្នុងឃ្លាំង
                            </th>

                            <th class="text-center" style="width: 140px;">
                                {{ __('product.actions') }}
                            </th>
                        </tr>
                    </thead>

                    <tbody id="productTableBody">
                        @include('admin.product.partials._row')
                    </tbody>

                </table>
            </div>

        </div>

        {{-- Pagination --}}
        @if ($products->hasPages())
            <div class="card-footer bg-white border-top">
                {{ $products->links() }}
            </div>
        @endif

    </div>

</x-admin-layout>
