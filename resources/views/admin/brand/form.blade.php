@php
    $brand = $brand ?? null;
@endphp

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-award me-2"></i>
                    {{ __('brand.details') }}
                </h5>
            </div>
            <div class="card-body p-4">

                <div class="row g-3">

                    <x-input name="name" :label="__('brand.name')" type="text" :value="old('name', $brand?->name)" :placeholder="__('brand.enter_name')" required
                        wrapper-class="col-12" />

                    <x-input name="description" :label="__('brand.description')" type="textarea" :value="old('description', $brand?->description)" :placeholder="__('brand.enter_description')"
                        wrapper-class="col-12" />

                    <x-input name="sort_order" :label="__('brand.sort_order')" type="number" :value="old('sort_order', $brand?->sort_order ?? 0)" :placeholder="__('brand.enter_sort_order')"
                        wrapper-class="col-md-6" />

                    <div class="col-md-6">

                        <div class="mb-3">

                            <label class="form-label">
                                {{ __('brand.is_active') }}
                            </label>

                            <div class="form-check form-switch mt-2">

                                <input type="checkbox" name="is_active" value="1" class="form-check-input"
                                    id="is_active" @checked(old('is_active', $brand?->is_active ?? true))>

                                <label class="form-check-label" for="is_active">
                                    {{ __('brand.active') }}
                                </label>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-image me-2"></i>
                    {{ __('brand.image') }}
                </h5>
            </div>

            <div class="card-body p-4">

                <div id="brand-image-preview"
                    class="border rounded-0 bg-light d-flex align-items-center justify-content-center mb-3"
                    style="height: 260px; overflow: hidden;">
                    @if ($brand?->img)
                        <img src="{{ $brand->showBrandLogo() }}" alt="{{ $brand->name }}" class="w-100 h-100"
                            style="object-fit: contain;">
                    @else
                        <div class="text-center text-muted">
                            <i class="bi bi-image fs-1 d-block mb-2"></i>
                            <span>{{ __('brand.select_image') }}</span>
                        </div>
                    @endif
                </div>

                <label for="image" class="form-label">
                    {{ __('brand.image') }}
                </label>

                <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp"
                    class="form-control rounded-0" data-preview="#brand-image-preview">

                <div class="form-text">
                    JPG, JPEG, PNG, WEBP — Max 2 MB
                </div>

                <div class="invalid-feedback" id="image-error"></div>

            </div>

        </div>

        <div class="card border-0 shadow-sm mt-3">

            <div class="card-body p-3">

                <button type="submit" class="btn btn-primary rounded-0 w-100">
                    <i class="bi bi-check-lg me-1"></i>

                    @if ($brand)
                        {{ __('brand.update') }}
                    @else
                        {{ __('brand.save') }}
                    @endif
                </button>

            </div>

        </div>

    </div>

</div>
