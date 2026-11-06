<x-admin-layout>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">បង្កើតតួនាទីថ្មី</h5>

            <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm rounded-0">
                <i class="fas fa-arrow-left me-1"></i> ត្រឡប់ក្រោយ
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-0">
            <div class="card-body">

                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">
                            ឈ្មោះតួនាទី <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="name" id="name"
                            class="form-control rounded-0 @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="ឧទាហណ៍: manager, teacher, accountant" required>

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('roles.index') }}" class="btn-sm btn btn-light rounded-0">
                            បោះបង់
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary rounded-0">
                            <i class="fas fa-save me-1"></i> រក្សាទុក
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</x-admin-layout>
