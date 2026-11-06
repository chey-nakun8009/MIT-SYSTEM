@php
    $unit = $unit ?? null;
@endphp

<input type="hidden" name="page" value="{{ $page ?? 1 }}">
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-0 mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-rulers align-middle me-2 text-danger"></i>
                    ឯកតាទំនិញ
                </h6>
            </div>
            <div class="card-body p-3 p-md-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <x-input name="name" :label="__('unit.name')" :placeholder="__('unit.enter_name')" :value="old('name', $unit?->name ?? '')" />
                    </div>
                    <div class="col-md-6">
                        <x-input name="symbol" :label="__('unit.symbol')" :placeholder="__('unit.enter_symbol')" :value="old('symbol', $unit?->symbol ?? '')" />
                    </div>
                    <div class="col-md-6">
                        <x-input name="type" :label="__('unit.type')" :placeholder="__('unit.enter_type')" :value="old('type', $unit?->type ?? '')" />
                    </div>
                    <div class="col-md-6">
                        <x-input name="decimal_places" :label="__('unit.decimal_places')" type="number" min="0" max="6"
                            :placeholder="__('unit.enter_decimal_places')" :value="old('decimal_places', $unit?->decimal_places ?? 3)" />
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
                    {{ __('unit.details') }}
                </h6>
            </div>

            <div class="card-body p-3">

                <div class="mb-3">
                    <div class="text-muted small mb-1">
                        {{ __('unit.name') }}
                    </div>

                    <div class="fw-semibold">
                        {{ $unit?->name ? Str::title($unit->name) : __('unit.new_unit') }}
                    </div>
                </div>

                @if ($unit)
                    <div class="mb-3">
                        <div class="text-muted small mb-1">
                            {{ __('unit.symbol') }}
                        </div>

                        <div class="fw-semibold">
                            {{ $unit->symbol }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small mb-1">
                            {{ __('unit.created') }}
                        </div>

                        <div>
                            {{ $unit->created_at?->format('d M Y, H:i') }}
                        </div>
                    </div>

                    <div>
                        <div class="text-muted small mb-1">
                            {{ __('unit.last_updated') }}
                        </div>

                        <div>
                            {{ $unit->updated_at?->format('d M Y, H:i') }}
                        </div>
                    </div>
                @else
                    <div class="text-muted small">
                        {{ __('unit.enter_information') }}
                    </div>
                @endif

            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-0">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">
                    {{ __('unit.form_actions') }}
                </h6>
            </div>

            <div class="card-body p-3">

                <button type="submit" class="btn btn-primary rounded-0 w-100 mb-2">

                    <i class="bi bi-check-lg align-middle me-1"></i>

                    {{ $unit ? __('unit.update') : __('unit.save') }}
                </button>

                <a href="{{ route('units.index') }}" class="btn btn-secondary rounded-0 w-100">

                    <i class="bi bi-x-lg align-middle me-1"></i>

                    {{ __('unit.cancel') }}
                </a>

            </div>
        </div>

    </div>
</div>
