<x-admin-layout>
    <div class="d-flex justify-content-between align-items-center mb-2 mb-lg-2">
        <div>
            <h1 class="h3 mb-0">{{ __('brand.title') }}</h1>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('brands.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                {{ __('brand.create') }}
            </a>
        </div>
    </div>
    <div>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
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
    </div>
</x-admin-layout>
