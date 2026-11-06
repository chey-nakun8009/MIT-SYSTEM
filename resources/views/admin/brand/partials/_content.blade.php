<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-1">{{ __('unit.title') }}</h4>
            </div>
            <a href="{{ route('brands.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                {{ __('brand.create') }}
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th class="col-no">#</th>
                        <th class="txt-start">{{ __('brand.image') }}</th>
                        <th class="txt-start">{{ __('brand.name') }}</th>
                        <th class="txt-start">{{ __('brand.description') }}</th>
                        <th class="txt-center">{{ __('brand.is_active') }}</th>
                        <th class="txt-center">{{ __('brand.sort_order') }}</th>
                        <th class="col-action">{{ __('brand.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @include('admin.brand.partials._row')
                </tbody>
            </table>
            <div id="supplierPagination" class="d-flex justify-content-end align-items-center p-3 border-top">
                {{ $brands->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>

    </div>
</div>
