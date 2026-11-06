@php
    $value = $value ?? null;
@endphp

<div class="row g-3">
    <div class="col-lg-8">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-list-ul me-2"></i>
                    {{ Str::title($attribute->name) }}
                </h5>
            </div>

            <div class="card-body p-4">

                <div class="row g-3">

                    <x-input name="value" :label="__('attribute_value.value')" type="text" :value="old('value', $value?->value)" :placeholder="__('attribute_value.enter_value')" required
                        wrapper-class="col-12" />

                    <x-input name="sort_order" :label="__('attribute_value.sort_order')" type="number" :value="old('sort_order', $value?->sort_order ?? 0)" :placeholder="__('attribute_value.enter_sort_order')"
                        wrapper-class="col-md-6" />

                    <div class="col-md-6">

                        <div class="mb-3">

                            <label class="form-label">
                                {{ __('attribute_value.is_active') }}
                            </label>

                            <div class="form-check form-switch mt-2">

                                <input type="checkbox" name="is_active" value="1" class="form-check-input"
                                    id="is_active" @checked(old('is_active', $value?->is_active ?? true))>

                                <label class="form-check-label" for="is_active">
                                    {{ __('attribute_value.active') }}
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
                    <i class="bi bi-info-circle me-2"></i>
                    {{ __('attribute_value.form_actions') }}
                </h5>
            </div>

            <div class="card-body p-4">

                <p class="text-muted mb-4">
                    {{ __('attribute_value.enter_information') }}
                </p>

                <button type="submit" class="btn btn-primary rounded-0 w-100">
                    <i class="bi bi-check-lg me-1"></i>

                    @if ($value)
                        {{ __('attribute_value.update') }}
                    @else
                        {{ __('attribute_value.save') }}
                    @endif
                </button>

                <a href="{{ route('attributes.values.index', [
                    'attribute' => $attribute->id,
                    'page' => request('page', 1),
                ]) }}"
                    class="btn btn-light border rounded-0 w-100 mt-2">
                    <i class="bi bi-x-lg me-1"></i>
                    {{ __('attribute_value.cancel') }}
                </a>

            </div>

        </div>

    </div>

</div>
