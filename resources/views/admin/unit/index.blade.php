<x-admin-layout>
    <div class="d-flex justify-content-end align-items-center mb-2 mb-lg-2">
        <div class="d-flex gap-2">
            <a href="{{ route('units.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                {{ __('unit.create') }}
            </a>
        </div>
    </div>
    <div>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="col-no">#</th>
                                <th>{{ __('unit.name') }}</th>
                                <th class="txt-center">{{ __('unit.symbol') }}</th>
                                <th class="txt-center">{{ __('unit.type') }}</th>
                                <th class="txt-center">{{ __('unit.decimal_places') }}</th>
                                <th class="col-action">{{ __('unit.action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="tableUnit">
                            @include('admin.unit.partials._row')
                        </tbody>
                    </table>
                    <div id="supplierPagination" class="d-flex justify-content-end align-items-center p-3 border-top">
                        {{ $units->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
