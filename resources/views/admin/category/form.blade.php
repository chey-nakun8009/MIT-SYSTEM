<div class="row g-2">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-0 mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">
                    <i class="material-icons align-middle me-2 text-danger"></i>
                    ប្រភេទផលិតផល
                </h6>
            </div>

            <div class="card-body p-3 p-md-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <x-input name="name" label="ឈ្មោះ" placeholder="បញ្ចូលឈ្មោះប្រភេទផលិតផល" :value="$category?->name" />
                    </div>
                    <div class="col-md-6">
                        <x-select name="parent_id" label="ប្រភេទផលិតផលមេ" :options="$categories->pluck('name', 'id')->toArray()" :value="$category?->parent_id"
                            placeholder="ក្រុមនៃផលិតផល" />
                    </div>
                    <div class="col-md-6">
                        <x-input name="slug" label="Slug" placeholder="category-slug" :value="$category?->slug" />
                        <small class="form-text text-muted">
                            មិនបញ្ចូលនឹងបង្កើតដោយស្វាយប្រវិត្ដ
                        </small>
                    </div>
                    <div class="col-md-6">
                        <x-input name="sort_order" label="លំដាប់នៃការដំរៀប" type="number" placeholder="0"
                            :value="$category?->sort_order ?? 0" />
                        <small class="form-text text-muted">
                            លេខតូចនឹងត្រូវបានដាក់បង្ហាញមុន
                        </small>
                    </div>
                    <div class="col-12">
                        <x-textarea name="description" label="ការបរិយាយផ្សេងៗ" placeholder="បញ្ចូលការបរិយាយផ្សេងៗ..."
                            :value="$category?->description" rows="5" />
                    </div>
                    <div class="col-12">
                        <label class="form-label d-block">
                            ធ្វើឲ្យសកម្ម
                        </label>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_active" value="1" class="form-check-input"
                                id="is_active" @checked(old('is_active', $category?->is_active ?? 1) == 1)>
                            <label class="form-check-label" for="is_active">
                                សកម្ម
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-0 mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">
                    <i class="material-icons align-middle me-2 text-danger"></i>
                    រូបភាព
                </h6>
            </div>
            <div class="card-body p-3">
                <div class="border bg-light d-flex align-items-center justify-content-center mb-3"
                    style="height:240px; overflow:hidden;">
                    <img src="{{ $category->showPhoto() }}" id="imagePreview" alt="រូពភាព"
                        class="img-fluid {{ $category?->img ? '' : 'd-none' }}"
                        style="max-height:100%; object-fit:contain;">
                    <div id="imagePlaceholder" class="text-center text-muted {{ $category?->img ? 'd-none' : '' }}">

                        <i class="material-icons" style="font-size:64px;"></i>
                        <p class="mb-0">
                            គ្មានរូបភាពត្រូវបានជ្រើសរើស
                        </p>
                    </div>
                </div>
                <div>
                    <label for="img" class="form-label">
                        ជ្រើសរើសរូបភាព
                    </label>
                    <input type="file" name="img" id="img" accept="image/jpeg,image/png,image/webp"
                        class="form-control @error('img') is-invalid @enderror">
                    @error('img')
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
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">
                    Form Actions
                </h6>
            </div>
            <div class="card-body p-3">
                <button type="submit" class="btn btn-danger rounded-0 w-100 mb-2">
                    <i class="material-icons align-middle me-1"></i>
                    រក្សាទុក
                </button>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary rounded-0 w-100">
                    <i class="material-icons align-middle me-1"></i>
                    បោះបង់
                </a>
            </div>

        </div>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const imageInput = document.getElementById('img');
        const imagePreview = document.getElementById('imagePreview');
        const imagePlaceholder = document.getElementById('imagePlaceholder');

        if (!imageInput || !imagePreview || !imagePlaceholder) {
            return;
        }

        imageInput.addEventListener('change', function() {

            const file = this.files[0];

            if (!file) {
                @if (!$category?->img)
                    imagePreview.src = '';
                    imagePreview.classList.add('d-none');
                    imagePlaceholder.classList.remove('d-none');
                @endif

                return;
            }

            if (!file.type.startsWith('image/')) {

                this.value = '';

                @if (!$category?->img)
                    imagePreview.src = '';
                    imagePreview.classList.add('d-none');
                    imagePlaceholder.classList.remove('d-none');
                @endif

                return;
            }

            imagePreview.src = URL.createObjectURL(file);
            imagePreview.classList.remove('d-none');
            imagePlaceholder.classList.add('d-none');

        });

    });
</script>
