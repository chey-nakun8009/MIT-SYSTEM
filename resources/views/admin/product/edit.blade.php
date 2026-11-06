<x-admin-layout>
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">កែប្រែផលិតផលថ្មី</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">
                            ផ្ទាំងគ្រប់គ្រង
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('products.index') }}">
                            ផលិតផល
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        ទម្រង់កែប្រែផលិតផល
                    </li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary rounded-0 mt-2 mt-md-0">
            <i class="bi bi-arrow-left me-1"></i>
            ត្រឡប់ក្រោយ
        </a>
    </div>
    @include('admin.product.form')
</x-admin-layout>
