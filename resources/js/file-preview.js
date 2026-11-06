document.addEventListener('change', function (e) {
    const input = e.target;
    if (!input.matches('input[type="file"][data-preview]')) {
        return;
    }

    const previewSelector = input.dataset.preview;
    const preview = document.querySelector(previewSelector);

    if (!preview) {
        return;
    }

    const file = input.files && input.files[0];

    if (!file) {
        preview.innerHTML = `
        <div class="text-center text-muted">
            <i class="bi bi-image fs-1 d-block mb-2"></i>
            <span>Select an image</span>
        </div>
    `;
        return;
    }

    if (!file.type.startsWith('image/')) {
        input.value = '';

        preview.innerHTML = `
        <div class="text-center text-danger">
            <i class="bi bi-exclamation-circle fs-1 d-block mb-2"></i>
            <span>Selected file is not an image.</span>
        </div>
    `;

        return;
    }

    const reader = new FileReader();

    reader.onload = function (event) {
        preview.innerHTML = '';

        const image = document.createElement('img');

        image.src = event.target.result;
        image.alt = 'Image preview';
        image.className = 'w-100 h-100';
        image.style.objectFit = 'contain';

        preview.appendChild(image);
    };

    reader.readAsDataURL(file);

});
