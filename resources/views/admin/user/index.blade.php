<x-admin-layout>
    <div class="d-flex justify-content-end align-items-center mb-4 mb-lg-4">
        <div class="d-flex gap-2">
            <a href="{{ route('users.create') }}" class="btn btn-sm rounded-0 btn-primary">
                <i class="bi bi-plus-lg me-2"></i>{{ __('user.create') }}
            </a>
        </div>
    </div>
    <div>
        @include('admin.user.partials._header')
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="h5 card-title mb-0">អ្នកប្រើប្រាស់</h2>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex gap-2">
                            <div class="position-relative">
                                <input id="searchUser" type="search" class="form-control form-control-sm"
                                    placeholder="Search..." style="width: 200px;">
                                <i
                                    class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-2 text-muted"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="txt-start">{{ __('user.name') }}</th>
                                <th>{{ __('user.role') }}</th>
                                <th>{{ __('user.contact') }}</th>
                                <th>{{ __('user.status') }}</th>
                                <th>{{ __('user.currency') }}</th>
                                <th>{{ __('user.language') }}</th>
                                <th style="width: 120px;">{{ __('user.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody id="tableUser">
                            @include('admin.user.partials._row')
                        </tbody>
                    </table>
                    <div id="userPagination" class="d-flex justify-content-end align-items-center p-3 border-top">
                        {{ $users->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('load', function() {
            if (typeof window.initLiveTable === 'function') {
                window.initLiveTable({
                    searchInputId: 'searchUser',
                    tableBodyId: 'tableUser',
                    paginationId: 'userPagination',
                    url: '{{ route('users.index') }}'
                });
            }
            const selectAllCheckbox = document.getElementById('selectAll');

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    const rowCheckboxes = document.querySelectorAll('#tableUser .user-checkbox');
                    rowCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                });
            }
        });
    </script>
</x-admin-layout>
