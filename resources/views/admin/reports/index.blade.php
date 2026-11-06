<x-admin-layout>
    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">របាយការណ៍ហិរញ្ញវត្ថុ</h4>
                <p class="text-muted small mb-0">គ្រប់គ្រងនិងតាមដានរបាយការណ៍ចំណូល និងចំណាយ</p>
            </div>
        </div>
        <ul class="nav nav-tabs border-bottom mb-4">
            <li class="nav-item">
                <a href="{{ route('reports.revenues') }}"
                    class="nav-link text-success fw-bold d-flex align-items-center gap-2 {{ request()->routeIs('reports.revenues*') ? 'active border-bottom border-success border-3 bg-white' : '' }}">
                    <i class="bi bi-file-earmark-spreadsheet fs-5"></i> របាយការណ៍ចំណូល
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('reports.expenses') }}"
                    class="nav-link text-danger fw-bold d-flex align-items-center gap-2 {{ request()->routeIs('reports.expenses*') ? 'active border-bottom border-danger border-3 bg-white' : '' }}">
                    <i class="bi bi-file-earmark-spreadsheet fs-5"></i> របាយការណ៍ចំណាយ
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('orders.index') }}"
                    class="nav-link text-info fw-bold d-flex align-items-center gap-2 {{ request()->routeIs('orders.index') ? 'active border-bottom border-info border-3 bg-white' : '' }}">
                    <i class="bi bi-receipt-cutoff fs-5"></i> របាយការណ៍លក់
                </a>
            </li>
        </ul>
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                @hasSection('settings_content')
                    @yield('settings_content')
                @else
                    <div class="text-center py-5">
                        <div class="mb-3 text-primary">
                            <i class="bi bi-bar-chart-line-fill display-4"></i>
                        </div>
                        <h5 class="fw-bold text-secondary">សូមស្វាគមន៍មកកាន់ប្រព័ន្ធរបាយការណ៍</h5>
                        <p class="text-muted mb-4">សូមជ្រើសរើសប្រភេទរបាយការណ៍ខាងលើ ឬចុចប៊ូតុងខាងក្រោមដើម្បីចាប់ផ្តើម។
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('reports.revenues') }}"
                                class="btn btn-success px-4 rounded-pill shadow-sm">
                                <i class="bi bi-arrow-down-circle me-1"></i> របាយការណ៍ចំណូល
                            </a>
                            <a href="{{ route('reports.expenses') }}"
                                class="btn btn-danger px-4 rounded-pill shadow-sm">
                                <i class="bi bi-arrow-up-circle me-1"></i> របាយការណ៍ចំណាយ
                            </a>
                            <a href="{{ route('orders.index') }}" class="btn btn-info px-4 rounded-pill shadow-sm">
                                <i class="bi bi-receipt-cutoff fs-5"></i> របាយការណ៍លក់
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
