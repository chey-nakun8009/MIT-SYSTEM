<div class="row">
    <div class="col-12 col-md-4 mb-3">
        <label class="form-label">
            ឈ្មោះសុីស្ទឹម
        </label>
        <input type="text" name="system_name" class="form-control rounded-0"
            value="{{ $settings['system_name']->value ?? '' }}">
    </div>
    <div class="col-6 col-md-4 mb-3">
        <label class="form-label">
            រូបភាព(Logo)
        </label>
        <div class="d-flex align-items-center gap-2">
            @if (isset($settings['system_logo']) && $settings['system_logo']->value)
                <img src="{{ asset('uploads/settings/' . $settings['system_logo']->value) }}" width="38"
                    height="38" class="rounded border p-1 bg-light object-fit-contain flex-shrink-0"
                    alt="L">
            @else
                <span class="text-muted small text-nowrap">គ្មានរូប</span>
            @endif
            <input type="file" name="system_logo" class="form-control rounded-0" accept=".png,.jpg,.jpeg,.webp,.svg">
        </div>
    </div>
    <div class="col-6 col-md-4 mb-3">
        <label class="form-label">
            Favicon
        </label>
        <div class="d-flex align-items-center gap-2">
            @if (isset($settings['favicon']) && $settings['favicon']->value)
                <img src="{{ asset('uploads/settings/' . $settings['favicon']->value) }}" alt="F"
                    width="38" height="38" class="rounded border p-1 bg-light object-fit-contain flex-shrink-0">
            @else
                <span class="text-muted small text-nowrap">No icon</span>
            @endif
            <input type="file" name="favicon" class="form-control rounded-0" accept=".png,.jpg,.jpeg,.ico,.webp">
        </div>
    </div>
</div>
