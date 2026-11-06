@isset($product)
    <form class="ajax-form" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
        id="productForm">
        @method('PUT')
    @else
        <form class="ajax-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
            id="productForm">
        @endisset
        @csrf
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-0 mb-3">

                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-box-seam me-2 text-danger"></i>
                            ព័ត៌មានផលិតផល
                        </h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <x-input name="name" label="ឈ្មោះផលិតផល" placeholder="បញ្ចូលឈ្មោះផលិតផល"
                                    :value="old('name', $product->name ?? '')" />
                            </div>
                            <div class="col-md-6">
                                <x-input name="sku" label="លេខSKU" placeholder="បញ្ចូលលេខSKU(មិនបញ្ចូលក៏បាន)"
                                    :value="old('sku', $product->sku ?? '')" />
                            </div>
                            <div class="col-md-6">
                                <x-select name="category_id" label="ប្រភេទផលិតផល" :options="$categories->pluck('name', 'id')->toArray()" :value="old('category_id', $product->category_id ?? '')" />
                            </div>
                            <div class="col-md-6">
                                <x-select name="brand_id" label="ម៉ាកយីហោផលិតផល" :options="$brands->pluck('name', 'id')->toArray()" :value="old('brand_id', $product->brand_id ?? '')" />
                            </div>
                            <div class="col-md-6">
                                <x-select name="base_unit_id" label="ឯកតាដើម" :options="$units->pluck('name', 'id')->toArray()" :value="old('base_unit_id', $product->base_unit_id ?? '')" />
                            </div>
                            <div class="col-md-6">
                                <x-select name="type" label="ប្រភេទនៃផលិតផល" :options="[
                                    'standard' => 'ផលិតផលទូទៅ',
                                    'office_supply' => 'ផលិតផលការិយាយល័យ',
                                ]" :value="old('type', $product->type ?? 'standard')" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-block">ស្ថានភាព</label>
                                <div class="form-check form-switch mt-2">
                                    <input type="checkbox" name="is_active" value="1" class="form-check-input"
                                        id="is_active" @checked(old('is_active', $product->is_active ?? true) == 1)>
                                    <label class="form-check-label" for="is_active">សកម្ម</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <x-textarea name="description" label="បរិយាយផ្សេងៗ"
                                    placeholder="បញ្ចូលការបរិយាយផ្សេងៗ..." :value="old('description', $product->description ?? '')" rows="4" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm rounded-0 mb-3">

                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0">
                                <i class="bi bi-rulers me-2 text-danger"></i>
                                ឯកតានិងតម្លៃលក់រាយ
                            </h6>
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-0" id="addUnit">
                                <i class="bi bi-plus-lg me-1"></i>បន្ថែមឯកតា
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle mb-2">
                                <thead class="table-light">
                                    <tr>
                                        <th style="min-width: 230px;">ប្រភេទឯកតា</th>
                                        <th style="min-width: 100px;">ឯកតាគុន</th>
                                        <th style="min-width: 100px;">តម្លៃលក់</th>
                                        <th class="txt-center" style="width: 80px;">ឯកតាដើម</th>
                                        <th class="txt-center" style="width: 80px;">ធ្វើឲ្យសកម្ម</th>
                                        <th class="txt-center" style="width: 70px;">កំណត់</th>
                                    </tr>
                                </thead>
                                <tbody id="unitTable"></tbody>
                            </table>
                        </div>
                        <small class="text-muted">
                            ចំនួនបម្លែង គឺជាឯកតាមូលដ្ឋានដែលមាននៅក្នុងឯកតាលក់មួយ (ឧទាហរណ៍៖ ១ ប្រអប់ = ១២ ដុំ
                            ដូច្នេះចំនួនបម្លែងគឺ ១២)។
                        </small>
                    </div>

                </div>

            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-0 mb-3">

                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-image me-2 text-danger"></i>
                            រូបភាពផលិតផល
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="border bg-light d-flex align-items-center justify-content-center mb-3"
                            style="height: 240px; overflow: hidden;">
                            @php
                                $imageUrl = isset($product) ? $product->primary_image_url : '';
                            @endphp
                            <img src="{{ $imageUrl }}" id="imagePreview" alt="Product preview"
                                class="img-fluid {{ empty($imageUrl) ? 'd-none' : '' }}"
                                style="max-height: 100%; object-fit: contain;">
                            <div id="imagePlaceholder"
                                class="text-center text-muted {{ !empty($imageUrl) ? 'd-none' : '' }}">
                                <i class="bi bi-image" style="font-size: 64px;"></i>
                                <p class="mb-0">មិនមានរូបភាព</p>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label for="image" class="form-label">ជ្រើសរើសរូបភាព</label>
                            <input type="file" name="image" id="image"
                                accept="image/jpeg,image/png,image/webp" class="form-control rounded-0"
                                data-preview="#imagePreview">
                            <div class="form-text text-muted">
                                JPG, PNG
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm rounded-0 mb-3">
                    <div class="card-body p-3">
                        <button type="submit" class="btn btn-primary rounded-0 w-100 mb-2">
                            <i class="bi bi-check-lg me-1"></i>រក្សាទុក
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary rounded-0 w-100">
                            <i class="bi bi-x-lg me-1"></i>បោះបង់
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </form>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const unitTable = document.getElementById('unitTable');
            const units =
                {{ Illuminate\Support\Js::from(
                    $units->map(function ($unit) {
                            return [
                                'id' => $unit->id,
                                'name' => $unit->name,
                                'symbol' => $unit->symbol ?? $unit->name,
                            ];
                        })->values(),
                ) }};

            const oldUnitOptions =
                {{ Illuminate\Support\Js::from(
                    old(
                        'unit_options',
                        isset($product)
                            ? $product->unitOptions->map(function ($opt) {
                                return [
                                    'unit_id' => $opt->unit_id,
                                    'conversion_factor' => $opt->conversion_factor,
                                    'price' => $opt->price,
                                    'is_default' => $opt->is_default,
                                    'is_active' => $opt->is_active,
                                ];
                            })
                            : [],
                    ),
                ) }};

            let unitIndex = 0;

            function escapeHtml(value) {
                return String(value ?? '').replace(/[&<>"']/g, function(char) {
                    return {
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#039;'
                    } [char];
                });
            }

            function unitOptions(selected = '') {
                return `
                <option value="">ជ្រើសរើសឯកតាផលិតផល</option>
                ${units.map(function (unit) {
                    return `
                                                    <option value="${unit.id}" ${String(selected) === String(unit.id) ? 'selected' : ''}>
                                                        ${escapeHtml(unit.name)} ${unit.symbol ? `(${escapeHtml(unit.symbol)})` : ''}
                                                    </option>
                                                `;
                }).join('')}
            `;
            }

            function addUnit(data = {}) {
                const index = unitIndex++;
                const row = document.createElement('tr');

                row.innerHTML = `
                <td>
                    <select name="unit_options[${index}][unit_id]" class="form-select form-select-sm rounded-0">
                        ${unitOptions(data.unit_id)}
                    </select>
                </td>
                <td>
                    <input type="number" name="unit_options[${index}][conversion_factor]" class="form-control form-control-sm rounded-0"
                        min="0.000001" step="0.000001" value="${escapeHtml(data.conversion_factor ?? '1')}">
                </td>
                <td>
                    <input type="number" name="unit_options[${index}][price]" class="form-control form-control-sm rounded-0"
                        min="0" step="0.001" value="${escapeHtml(data.price ?? '')}" placeholder="0.000">
                </td>
                <td class="txt-center">
                    <input type="radio" name="default_unit" value="${index}" class="form-check-input default-unit"
                        ${data.is_default == 1 ? 'checked' : ''}>
                    <input type="hidden" name="unit_options[${index}][is_default]" value="0" class="default-unit-value">
                </td>
                <td class="txt-center">
                    <div class="form-check d-flex justify-content-center">
                        <input type="checkbox" name="unit_options[${index}][is_active]" value="1" class="form-check-input"
                            ${data.is_active === false || data.is_active === 0 ? '' : 'checked'}>
                    </div>
                </td>
                <td class="txt-center">
                    <button type="button" class="btn btn-sm btn-action text-danger remove-unit" title="Remove unit">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;

                unitTable.appendChild(row);

                row.querySelector('.remove-unit').addEventListener('click', function() {
                    row.remove();
                    syncDefaultUnits();
                });

                row.querySelector('.default-unit').addEventListener('change', syncDefaultUnits);

                if (unitTable.querySelectorAll('tr').length === 1) {
                    row.querySelector('.default-unit').checked = true;
                }

                syncDefaultUnits();
            }

            function syncDefaultUnits() {
                const rows = [...unitTable.querySelectorAll('tr')];

                if (rows.length && !rows.some(row => row.querySelector('.default-unit').checked)) {
                    rows[0].querySelector('.default-unit').checked = true;
                }

                rows.forEach(row => {
                    const radio = row.querySelector('.default-unit');
                    const hidden = row.querySelector('.default-unit-value');
                    hidden.value = radio.checked ? '1' : '0';
                });
            }

            document.getElementById('addUnit').addEventListener('click', function() {
                addUnit();
            });

            if (oldUnitOptions.length) {
                oldUnitOptions.forEach(unit => addUnit(unit));
            } else {
                addUnit();
            }

            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const imagePlaceholder = document.getElementById('imagePlaceholder');

            imageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (!file || !file.type.startsWith('image/')) {
                    this.value = '';
                    imagePreview.src = '';
                    imagePreview.classList.add('d-none');
                    imagePlaceholder.classList.remove('d-none');
                    return;
                }

                imagePreview.src = URL.createObjectURL(file);
                imagePreview.classList.remove('d-none');
                imagePlaceholder.classList.add('d-none');
            });

            document.getElementById('productForm').addEventListener('submit', function() {
                syncDefaultUnits();
            });
        });
    </script>
