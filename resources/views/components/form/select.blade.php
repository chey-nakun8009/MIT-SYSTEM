@props(['name', 'label' => '', 'options' => [], 'selected' => null, 'required' => false, 'class' => 'col-12'])
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
            <option value="">----ជ្រើសរើស----</option>
            @foreach ($options as $value => $text)
                <option class="text-capitalize" value="{{ $value }}" @selected(old($name, $selected) == $value)>
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
