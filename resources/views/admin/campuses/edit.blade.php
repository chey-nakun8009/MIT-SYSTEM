<x-admin-layout>
    <div class="container-fluid">
        <div class="page-header mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="page-header-icon d-flex align-items-center justify-content-center">
                        @if (setting('system_logo'))
                            <img src="{{ asset('uploads/settings/' . setting('system_logo')) }}"
                                alt="{{ setting('system_name', 'Mkot Glass') }}" class="d-block"
                                style="width: {{ setting('logo_width', 'auto') }};
                                height: {{ setting('logo_height', '40px') }};
                                border-radius: {{ setting('logo_border_radius', '0') }};">
                        @else
                            <img src="{{ asset('photos/mkot.png') }}" alt="Logo" height="40" class="d-block">
                        @endif
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">
                            កែប្រែព័ត៌មានសាខា
                        </h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('campuses.index') }}">
                                        សាខា
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    កែប្រែសាខា
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <a href="{{ route('campuses.index') }}" class="btn btn-outline-secondary btn-sm rounded-0 px-3">
                    <i class="bi bi-arrow-left me-1"></i>
                    ត្រឡប់ក្រោយ
                </a>
            </div>
        </div>
        <form action="{{ route('campuses.update', $campus) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.campuses.form')
        </form>
    </div>
</x-admin-layout>
