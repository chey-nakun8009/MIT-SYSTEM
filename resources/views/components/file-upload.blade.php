@php
    use Illuminate\Support\Str;
@endphp

@props(['name', 'label' => '', 'image' => null])

<div class="mb-3">
    <label class="form-label fw-bold">{{ $label }}</label>

    <div class="border-dashed rounded-0 p-3 text-center bg-light position-relative"
        style="cursor:pointer;border-color:#dee2e6;" onclick="document.getElementById('{{ $name }}').click()"
        onmouseover="this.style.borderColor='#BA7D02'" onmouseout="this.style.borderColor='#dee2e6'">

        <input type="file" name="{{ $name }}" id="{{ $name }}" class="d-none"
            onchange="previewFile{{ Str::studly($name) }}(this)">

        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height:150px;">

            <div id="placeholder-{{ $name }}" {{ $image ? 'style=display:none;' : '' }}>
                <i class="bi bi-image fs-1 text-primary"></i>
                <p class="mt-2 text-muted small">Choose file</p>
            </div>

            <img id="image-preview-{{ $name }}" src="{{ $image }}"
                class="img-thumbnail shadow-sm {{ $image ? '' : 'd-none' }}"
                style="width:200px;height:150px;object-fit:cover;">
        </div>
    </div>
</div>

<script>
    function previewFile{{ Str::studly($name) }}(input) {
        const preview = document.getElementById('image-preview-{{ $name }}');
        const placeholder = document.getElementById('placeholder-{{ $name }}');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                placeholder.style.display = 'none';
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
