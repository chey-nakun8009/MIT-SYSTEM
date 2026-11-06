@php
    $variant = $variant ?? null;
    $products = $products ?? collect();
@endphp

<div class="row g-3">

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm rounded-0 mb-3">

            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-diagram-3 align-middle me-2 text-danger"></i>
                    {{ __('variant.details') }}
                </h6>
            </div>

            <div class="card-body p-3 p-md-4">
                <div class="row g-3">
                    <div class="col-12">
                        <x-select name="product_id" :label="__('variant.product')" :options="$products->pluck('name', 'id')->toArray()" :selected="old('product_id', $variant?->product_id)" required />
                    </div>

                    <div class="col-md-6">

                        <x-input name="sku" :label="__('variant.sku')" :placeholder="__('variant.enter_sku')" :value="old('sku', $variant?->sku ?? '')" />

                    </div>

                    <div class="col-md-6">

                        <x-input name="price" type="number" step="0.01" min="0" :label="__('variant.price')"
                            :placeholder="__('variant.enter_price')" :value="old('price', $variant?->price ?? '')" />

                    </div>

                    <div class="col-md-6">

                        <x-input name="weight_kg" type="number" step="0.01" min="0" :label="__('variant.weight_kg')"
                            :placeholder="__('variant.enter_weight')" :value="old('weight_kg', $variant?->weight_kg ?? '')" />

                    </div>

                    <div class="col-md-6">

                        <div class="form-check form-switch mt-4 pt-2">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                                value="1" {{ old('is_active', $variant?->is_active ?? true) ? 'checked' : '' }}>

                            <label class="form-check-label" for="is_active">
                                {{ __('variant.is_active') }}
                            </label>
                        </div>

                    </div>

                    <div class="col-12">

                        <label for="attributes" class="form-label fw-semibold">
                            {{ __('variant.attributes') }}
                        </label>

                        <textarea name="attributes" id="attributes" rows="5" class="form-control rounded-0"
                            placeholder='{"color":"Red","size":"Large"}'>{{ old('attributes', $variant?->attributes ? json_encode($variant->attributes) : '') }}</textarea>

                        <div class="form-text">
                            {{ __('variant.enter_attributes') }}
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
                    <i class="bi bi-info-circle align-middle me-2 text-danger"></i>
                    {{ __('variant.details') }}
                </h6>
            </div>

            <div class="card-body p-3">

                <div class="mb-3">

                    <div class="text-muted small mb-1">
                        {{ __('variant.product') }}
                    </div>

                    <div class="fw-semibold">
                        {{ $variant?->product?->name ?? __('variant.new_variant') }}
                    </div>

                </div>

                @if ($variant)
                    <div class="mb-3">

                        <div class="text-muted small mb-1">
                            {{ __('variant.sku') }}
                        </div>

                        <div class="fw-semibold">
                            {{ $variant->sku }}
                        </div>

                    </div>

                    <div class="mb-3">

                        <div class="text-muted small mb-1">
                            {{ __('variant.created') }}
                        </div>

                        <div>
                            {{ $variant->created_at?->format('d M Y, H:i') }}
                        </div>

                    </div>

                    <div>

                        <div class="text-muted small mb-1">
                            {{ __('variant.last_updated') }}
                        </div>

                        <div>
                            {{ $variant->updated_at?->format('d M Y, H:i') }}
                        </div>

                    </div>
                @else
                    <div class="text-muted small">
                        {{ __('variant.enter_information') }}
                    </div>
                @endif

            </div>

        </div>

        <div class="card border-0 shadow-sm rounded-0">

            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">
                    {{ __('variant.form_actions') }}
                </h6>
            </div>

            <div class="card-body p-3">

                <button type="submit" class="btn btn-primary rounded-0 w-100 mb-2">

                    <i class="bi bi-check-lg align-middle me-1"></i>

                    {{ $variant ? __('variant.update') : __('variant.save') }}

                </button>

                <a href="{{ route('product-variants.index') }}" class="btn btn-secondary rounded-0 w-100">

                    <i class="bi bi-x-lg align-middle me-1"></i>

                    {{ __('variant.cancel') }}

                </a>

            </div>

        </div>

    </div>

</div>
