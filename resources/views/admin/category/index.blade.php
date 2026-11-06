<x-admin-layout>
    <div class="d-flex justify-content-end align-items-center mb-2 mb-lg-2">
        <div class="d-flex gap-2">
            <a href="{{ route('categories.create') }}" class="btn btn-xs rounded-0 btn-primary">
                <i class="bi bi-plus-lg me-2"></i>បង្កើតថ្មី
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
                                <th class="txt-start">ឈ្មោះ</th>
                                <th>លំដាប់</th>
                                <th>Status</th>
                                <th>បរិយាយ</th>
                                <th style="width: 120px;">គ្រប់គ្រង</th>
                            </tr>
                        </thead>
                        <tbody id="tableCategory">
                            @include('admin.category.partials._row')
                        </tbody>
                    </table>
                    <div id="categoryPagination" class="d-flex justify-content-end align-items-center p-3 border-top">
                        {{ $categories->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
