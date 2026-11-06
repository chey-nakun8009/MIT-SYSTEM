@props([
    'name',
    'label' => '',
    'options' => [],
    'selected' => null,
    'value' => null,
    'required' => false,
    'class' => 'col-12',
])

@php
    $selectedValue = $selected ?? $value;
@endphp

<div class="{{ $class }}">
    <div class="mb-3">
        <label for="{{ $name }}" class="form-label {{ $errors->has($name) ? 'text-danger' : '' }}">
            {{ $label }}
            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
        <select id="{{ $name }}" name="{{ $name }}" {{ $required ? 'required' : '' }}
            {{ $attributes->merge([
                'class' => 'form-select rounded-0 ' . ($errors->has($name) ? 'is-invalid' : ''),
            ]) }}>
            <option value="">-- ជ្រើសរើស --</option>
            @foreach ($options as $val => $text)
                <option class="text-capitalize" value="{{ $val }}" @selected(old($name, $selectedValue) == $val)>
                    {{ $text }}
                </option>
            @endforeach
        </select>
        @error($name)
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
