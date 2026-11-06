<x-admin-layout>
    <div class="container-fluid px-4 py-2">
        <div class="mb-4">
            <h4 class="fw-bold text-dark">ប្រភេទចំណូលនិងចំណាយ</h4>
            <p class="text-muted small">គ្រប់គ្រងប្រភេទនិងរចនាសម្ព័ន្ធផ្សេងៗរបស់កម្មវិធី។</p>
        </div>
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a href="{{ route('revenue-categories.index') }}"
                    class="text-success fw-bold nav-link d-flex align-items-center gap-2 {{ request()->routeIs('revenue-categories.*') ? 'active fw-semibold' : '' }}">
                    <i class="bi bi-plus-circle"></i> ប្រភេទចំណូល
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('expense-categories.index') }}"
                    class="text-danger fw-bold nav-link d-flex align-items-center gap-2 {{ request()->routeIs('expense-categories.*') ? 'active fw-semibold' : '' }}">
                    <i class="bi bi-dash-circle"></i> ប្រភេទចំណាយ
                </a>
            </li>

        </ul>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                @hasSection('settings_content')
                    @yield('settings_content')
                @else
                    <div class="text-center py-5">
                        <div class="mb-3 text-muted">
                            <i class="bi bi-gear-wide-connected fs-1"></i>
                        </div>
                        <h5 class="fw-bold text-secondary">ប្រភេទចំណូលនិងចំណាយ</h5>
                        <p class="text-muted mb-4">សូមជ្រើសរើសការកំណត់ណាមួយពីម៉ឺនុយ ដើម្បីចាប់ផ្តើមប្រើប្រាស់។</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('revenue-categories.index') }}" class="btn btn-sm btn-success rounded-0">
                                កំណត់ប្រភេទចំណូល
                            </a>
                            <a href="{{ route('expense-categories.index') }}" class="btn btn-sm btn-danger rounded-0">
                                កំណត់ប្រភេទចំណាយ
                            </a>

                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
