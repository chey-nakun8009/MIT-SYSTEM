<x-admin-layout>
    <div class="d-flex justify-content-end align-items-center mb-2 mb-lg-2">
        <div class="d-flex gap-2">
            <a href="{{ route('suppliers.create') }}" class="btn btn-sm rounded-0 btn-primary">
                <i class="bi bi-plus-lg me-2"></i>{{ __('supplier.create') }}
            </a>
        </div>
    </div>
    <div>
        @include('admin.supplier.partials._header')
        <div class="card">
            @include('admin.supplier.partials._filter')
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40px;">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th>{{ __('supplier.supplier_name') }}</th>
                                <th class="sortable">{{ __('supplier.email') }}</th>
                                <th class="col-contact">{{ __('supplier.contact') }}</th>
                                <th>{{ __('supplier.address') }}</th>
                                <th class="txt-center">{{ __('supplier.tax_number') }}</th>
                                <th class="txt-center">{{ __('supplier.status') }}</th>
                                <th class="txt-center">{{ __('supplier.note') }}</th>
                                <th class="col-action">{{ __('supplier.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody id="tableSupplier">
                            @include('admin.supplier.partials._row')
                        </tbody>
                    </table>
                    <div id="supplierPagination" class="d-flex justify-content-end align-items-center p-3 border-top">
                        {{ $suppliers->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.SupplierConfig = {
            indexUrl: @json(route('suppliers.index'))
        };
        window.addEventListener('load', function() {
            if (typeof window.initLiveTable === 'function') {
                window.initLiveTable({
                    searchInputId: 'searchSupplier',
                    tableBodyId: 'tableSupplier',
                    paginationId: 'supplierPagination',
                    url: window.SupplierConfig.indexUrl
                });
            }
            const selectAllCheckbox = document.getElementById('selectAll');
            if (typeof window.initSelectAll === 'function') {
                window.initSelectAll({
                    selectAllId: 'selectAll',
                    tableBodyId: 'tableSupplier',
                    checkboxSelector: '.user-checkbox'
                });
            }
        });
    </script>
</x-admin-layout>
