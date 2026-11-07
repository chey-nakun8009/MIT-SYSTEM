<x-guest-layout>
    <div class="mb-4 text-center">
        <h3 class="fw-bold text-dark mb-1">បង្កើតសាខាសាលារៀន</h3>
        <p class="text-muted small">សូមបំពេញព័ត៌មានសាខារបស់លោកអ្នកដើម្បីបញ្ចប់ការចុះឈ្មោះ</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show mb-3 py-2 small" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('auth.campus.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold small text-secondary">
                ឈ្មោះសាខា <span class="text-danger">*</span>
            </label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-building"></i></span>
                <input id="name" class="form-control border-start-0 @error('name') is-invalid @enderror"
                    type="text" name="name" value="{{ old('name') }}" placeholder="ឧ. សាខាទួលគោក ឬ Main Campus"
                    required autofocus>
            </div>
            @error('name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="slug" class="form-label fw-semibold small text-secondary">
                Slug (Optional)
            </label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-link-45deg"></i></span>
                <input id="slug" class="form-control border-start-0 @error('slug') is-invalid @enderror"
                    type="text" name="slug" value="{{ old('slug') }}"
                    placeholder="arak-tuol-kouk (ទុកទំនេរវានឹងបង្កើតដោយស្វ័យប្រវត្តិ)">
            </div>
            @error('slug')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campus Logo -->
        <div class="mb-4">
            <label for="logo" class="form-label fw-semibold small text-secondary">
                ឡូហ្គោសាខា (Campus Logo)
            </label>
            <input id="logo" class="form-control @error('logo') is-invalid @enderror" type="file" name="logo"
                accept="image/*">
            <div class="form-text text-muted" style="font-size: 0.75rem;">ទ្រង់ទ្រាយរូបភាព៖ JPG, PNG, WEBP (អតិបរមា 2MB)
            </div>
            @error('logo')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary py-2 fw-semibold shadow-sm">
                <i class="bi bi-check-circle me-1"></i> បង្កើតសាខា និងបន្តទៅផ្ទាំងគ្រប់គ្រង
            </button>
        </div>
    </form>
</x-guest-layout>
