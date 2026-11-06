<x-admin-layout>
    <div class="container-fluid">

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold mb-1">
                    Edit Category
                </h4>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-0">

                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">
                                Dashboard
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            <a href="{{ route('users.index') }}">
                                User
                            </a>
                        </li>

                        <li class="breadcrumb-item active" aria-current="page">
                            Edit
                        </li>

                    </ol>
                </nav>
            </div>

            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary rounded-0 mt-2 mt-md-0">

                <i class="material-icons align-middle me-1"></i>

                Back to Categories
            </a>

        </div>

        <form class="ajax-form" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            @include('admin.user.form')
        </form>

    </div>
</x-admin-layout>
