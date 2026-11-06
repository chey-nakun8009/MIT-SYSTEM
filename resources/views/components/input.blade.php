@props(['name', 'label', 'type' => 'text', 'value' => null, 'required' => false, 'class' => 'col-12'])
<div class="{{ $class }}">
    <div class="mb-3">

        <label for="{{ $name }}" class="form-label {{ $errors->has($name) ? 'text-danger' : '' }}">
            {{ $label }}

            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>

        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
            value="{{ old($name, $value) }}" {{ $required ? 'required' : '' }}
            {{ $attributes->merge([
                'class' => 'form-control rounded-0 ' . ($errors->has($name) ? 'is-invalid' : ''),
            ]) }}>

        @error($name)
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror

    </div>
</div>
