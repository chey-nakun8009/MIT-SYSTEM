<div class="row g-3">

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white border-bottom py-3">

                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-sliders me-2"></i>
                    {{ __('product_setting.product_settings') }}
                </h5>

            </div>

            <div class="card-body p-4">

                <div class="row g-3">

                    <div class="col-md-6">

                        <label class="form-label">
                            {{ __('product_setting.default_product_type') }}
                        </label>

                        <select name="default_product_type" class="form-select rounded-0">
                            <option value="standard" @selected(old('default_product_type', $settings->default_product_type) === 'standard')>
                                {{ __('product_setting.standard') }}
                            </option>

                            <option value="glass" @selected(old('default_product_type', $settings->default_product_type) === 'glass')>
                                {{ __('product_setting.glass') }}
                            </option>
                        </select>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            {{ __('product_setting.default_unit') }}
                        </label>

                        <select name="default_unit_id" class="form-select rounded-0">

                            <option value="">
                                {{ __('product_setting.no_default_unit') }}
                            </option>

                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" @selected(old('default_unit_id', $settings->default_unit_id) == $unit->id)>
                                    {{ $unit->name }}
                                    ({{ $unit->symbol }})
                                </option>
                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6">

                        <x-input name="decimal_places" :label="__('product_setting.decimal_places')" type="number" min="0" max="6"
                            :value="old('decimal_places', $settings->decimal_places)" :placeholder="__('product_setting.enter_decimal_places')" />

                    </div>

                    <div class="col-md-6">

                        <x-input name="low_stock_threshold" :label="__('product_setting.low_stock_threshold')" type="number" min="0"
                            step="0.001" :value="old('low_stock_threshold', $settings->low_stock_threshold)" :placeholder="__('product_setting.enter_low_stock_threshold')" />

                    </div>

                </div>

            </div>

        </div>

        <div class="card border-0 shadow-sm mt-3">

            <div class="card-header bg-white border-bottom py-3">

                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-box-seam me-2"></i>
                    {{ __('product_setting.stock_settings') }}
                </h5>

            </div>

            <div class="card-body p-4">

                <div class="row g-3">

                    <div class="col-md-6">

                        <div class="form-check form-switch">

                            <input type="checkbox" name="allow_negative_stock" value="1" class="form-check-input"
                                id="allow_negative_stock" @checked(old('allow_negative_stock', $settings->allow_negative_stock))>

                            <label class="form-check-label" for="allow_negative_stock">
                                {{ __('product_setting.allow_negative_stock') }}
                            </label>

                        </div>

                        <small class="text-muted">
                            {{ __('product_setting.allow_negative_stock_help') }}
                        </small>

                    </div>

                    <div class="col-md-6">

                        <div class="form-check form-switch">

                            <input type="checkbox" name="allow_inactive_sales" value="1" class="form-check-input"
                                id="allow_inactive_sales" @checked(old('allow_inactive_sales', $settings->allow_inactive_sales))>

                            <label class="form-check-label" for="allow_inactive_sales">
                                {{ __('product_setting.allow_inactive_sales') }}
                            </label>

                        </div>

                        <small class="text-muted">
                            {{ __('product_setting.allow_inactive_sales_help') }}
                        </small>

                    </div>

                </div>

            </div>

        </div>

        <div class="card border-0 shadow-sm mt-3">

            <div class="card-header bg-white border-bottom py-3">

                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-upc-scan me-2"></i>
                    {{ __('product_setting.sku_settings') }}
                </h5>

            </div>

            <div class="card-body p-4">

                <div class="row g-3">

                    <div class="col-md-6">

                        <div class="form-check form-switch">

                            <input type="checkbox" name="require_sku" value="1" class="form-check-input"
                                id="require_sku" @checked(old('require_sku', $settings->require_sku))>

                            <label class="form-check-label" for="require_sku">
                                {{ __('product_setting.require_sku') }}
                            </label>

                        </div>

                        <small class="text-muted">
                            {{ __('product_setting.require_sku_help') }}
                        </small>

                    </div>

                    <div class="col-md-6">

                        <div class="form-check form-switch">

                            <input type="checkbox" name="auto_generate_sku" value="1" class="form-check-input"
                                id="auto_generate_sku" @checked(old('auto_generate_sku', $settings->auto_generate_sku))>

                            <label class="form-check-label" for="auto_generate_sku">
                                {{ __('product_setting.auto_generate_sku') }}
                            </label>

                        </div>

                        <small class="text-muted">
                            {{ __('product_setting.auto_generate_sku_help') }}
                        </small>

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
                    {{ __('product_setting.form_actions') }}
                </h5>

            </div>

            <div class="card-body p-4">

                <p class="text-muted mb-4">
                    {{ __('product_setting.enter_information') }}
                </p>

                <button type="submit" class="btn btn-primary rounded-0 w-100">
                    <i class="bi bi-check-lg me-1"></i>
                    {{ __('product_setting.save') }}
                </button>

            </div>

        </div>

    </div>

</div>
