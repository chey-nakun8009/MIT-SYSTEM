<x-admin-layout>
    <div class="container-fluid">

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">
                    កែប្រែព័ត៍មានអ្នកប្រើ
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">
                                ផ្ទាំំងគ្រប់គ្រង
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.index') }}">
                                បញ្ជីអ្នកប្រើ
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            កំពុងកែប្រែ
                        </li>
                    </ol>
                </nav>
            </div>

            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary rounded-0 mt-2 mt-md-0">
                <i class="material-icons align-middle me-1"></i>
                ត្រឡប់ក្រោយ
            </a>
        </div>
        <form class="ajax-form" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            @include('admin.user.form')
        </form>
    </div>
</x-admin-layout>
