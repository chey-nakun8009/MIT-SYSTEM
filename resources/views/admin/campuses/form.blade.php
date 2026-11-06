@php
    $campus = $campus ?? new \App\Models\Campus();
@endphp

@csrf
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-0 mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">
                    ព័ត៌មានសាខា
                </h6>
            </div>
            <div class="card-body p-3">
                <div class="row g-3">
                    <div class="col-md-6">
                        <x-input id="name" name="name" label="ឈ្មោះ" placeholder="បញ្ចូលឈ្មោះសាខា"
                            :value="old('name', $campus->name)" />
                    </div>
                    <div class="col-md-6">
                        <x-input name="slug" id="slug" label="Slug(បង្កើតដោយស្វាយប្រវត្ត)"
                            placeholder="បញ្ចូល Slug" :value="old('slug', $campus->slug)" />
                    </div>
                    <div class="col-md-6">
                        <x-input name="email" label="អុីមែល" placeholder="បញ្ចូលអុីមែល" :value="old('email', $campus->email)" />
                    </div>
                    <div class="col-md-6">
                        <x-input name="phone" label="លេខទូរស័ព្ទ" placeholder="លេខទូរស័ព្ទ" :value="old('phone', $campus->phone)" />
                    </div>

                    <div class="col-md-6">
                        <x-select name="status" label="Status" :options="['active' => 'Active', 'inactive' => 'Inactive', 'suspended' => 'Suspended']" :selected="old('status', $campus->status ?? 'active')" />
                    </div>

                    <div class="col-md-6">
                        <x-select name="currency" label="Currency" :options="['USD' => 'USD ($)', 'EUR' => 'EUR (€)', 'GBP' => 'GBP (£)', 'KHR' => 'KHR (៛)']" :selected="old('currency', $campus->currency ?? 'USD')" />
                    </div>
                    <div class="col-md-6">
                        <x-input name="timezone" label="Timezone" placeholder="UTC" :value="old('timezone', $campus->timezone ?? 'UTC')" />
                    </div>

                    <div class="col-md-6">
                        <x-input name="locale" label="Locale" :value="old('locale', $campus->locale ?? 'en')" maxlength="10" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-0 mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">
                    <i class="material-icons align-middle me-2 text-danger">image</i>
                    ឡូហ្គោសាខា
                </h6>
            </div>
            <div class="card-body p-3">
                <div class="border bg-light d-flex align-items-center justify-content-center mb-3"
                    style="height:240px; overflow:hidden;">
                    <img src="{{ $campus->showCampusLogo() }}" id="imagePreview" alt="រូបភាពសាខា" class="img-fluid"
                        style="max-height:100%; object-fit:contain;">
                </div>
                <div>
                    <label for="img" class="form-label">
                        ជ្រើសរើសរូបភាព
                    </label>
                    <input type="file" name="logo" id="img" accept="image/jpeg,image/png,image/webp"
                        class="form-control @error('logo') is-invalid @enderror">
                    @error('logo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="form-text">
                        ទម្រង់រូបភាពដែលគាំទ្រ: JPG, PNG, WEBP.
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-0">
            <div class="card-body p-3 d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-xs rounded-0 py-2">រក្សាទុក</button>
                <a href="{{ route('campuses.index') }}" class="btn btn-secondary btn-xs rounded-0 py-2">បោះបង់</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('img');
        const imagePreview = document.getElementById('imagePreview');
        const defaultLogo = "{{ $campus->showCampusLogo() }}";

        if (imageInput && imagePreview) {
            imageInput.addEventListener('change', function() {
                const file = this.files[0];

                if (!file || !file.type.startsWith('image/')) {
                    if (!file) {
                        this.value = '';
                    }
                    imagePreview.src = defaultLogo;
                    return;
                }
                imagePreview.src = URL.createObjectURL(file);
            });
        }
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        if (nameInput && slugInput) {
            let isSlugManuallyEdited = slugInput.value.trim() !== '';

            function generateSlug(text) {
                return text.toString().toLowerCase()
                    .trim()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-');
            }

            slugInput.addEventListener('input', function() {
                isSlugManuallyEdited = this.value.trim() !== '';
            });

            nameInput.addEventListener('input', function() {
                if (!isSlugManuallyEdited) {
                    slugInput.value = generateSlug(this.value);
                }
            });
        }
    });
</script>
