@props(['name', 'label', 'value' => null, 'rows' => 3, 'required' => false, 'class' => 'col-12'])

<div class="{{ $class }}">
    <div class="mb-3">

        <label for="{{ $name }}" class="form-label {{ $errors->has($name) ? 'text-danger' : '' }}">
            {{ $label }}

            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>

        <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}" {{ $required ? 'required' : '' }}
            {{ $attributes->merge([
                'class' => 'form-control rounded-0 ' . ($errors->has($name) ? 'is-invalid' : ''),
            ]) }}>{{ old($name, $value) }}</textarea>

        @error($name)
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror

    </div>
</div>
