<x-admin-layout>
    <div class="container-fluid px-4 py-3">
        <div class="page-header mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="page-header-icon d-flex align-items-center justify-content-center">
                        @if (setting('system_logo'))
                            <img src="{{ asset('storage/uploads/settings/' . setting('system_logo')) }}"
                                alt="{{ setting('system_name', 'Mkot Glass') }}" class="d-block"
                                style="width: {{ setting('logo_width', 'auto') }};
                                height: {{ setting('logo_height', '40px') }};
                                border-radius: {{ setting('logo_border_radius', '0') }};">
                        @else
                            <img src="{{ asset('photos/login_logo.png') }}" alt="Logo" height="40" class="d-block">
                        @endif
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">
                            បញ្ចូលស្តុកទំនិញចូលឃ្លាំង
                        </h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('inventory-transactions.index') }}">
                                        ផលិតផល
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    បញ្ចូលស្តុក
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <a href="{{ route('inventory-transactions.index') }}"
                    class="btn btn-outline-secondary btn-sm rounded-0 px-3">
                    <i class="bi bi-arrow-left me-1"></i>
                    ត្រឡប់ក្រោយ
                </a>

            </div>
        </div>
        <form class="ajax-form" action="{{ route('inventory-transactions.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-0 mb-3">
                        <div class="card-header bg-white py-3">
                            <h3 class="fw-bold mb-0">
                                <i class="bi bi-box-arrow-in-down me-2"></i> ព័ត៌មានទទួលទំនិញចូល
                            </h3>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label for="product_id" class="form-label fw-semibold">ជ្រើសរើសផលិតផល
                                        <span class="text-danger">*</span></label>
                                    <select name="product_id" id="product_id" class="form-select rounded-0" required>
                                        <option value="">-- ជ្រើសរើសផលិតផល --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ Str::title($product->name) }} (SKU:
                                                {{ $product->sku }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="unit_id" class="form-label fw-semibold">ឯកតាលក់/ទទួល <span
                                            class="text-danger">*</span></label>
                                    <select name="unit_id" id="unit_id" class="form-select rounded-0" required>
                                        <option value="">-- សូមជ្រើសរើសផលិតផលជាមុន --</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="quantity" class="form-label fw-semibold">ចំនួនទទួល<span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="quantity" id="quantity" class="form-control rounded-0"
                                        min="0.001" step="0.001" placeholder="0.00" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="cost_price" class="form-label fw-semibold">ថ្លៃដើមទិញក្នុង១ឯកតា</label>
                                    <input type="number" name="cost_price" id="cost_price"
                                        class="form-control rounded-0" min="0" step="0.001"
                                        placeholder="0.000">
                                </div>
                                <div class="col-md-3">
                                    <label for="reference_no" class="form-label fw-semibold">លេខយោងវិក្កយបត្រ</label>
                                    <input type="text" name="reference_no" id="reference_no"
                                        class="form-control rounded-0" placeholder="INV-2026-001">
                                </div>
                                <div class="col-md-6">
                                    <label for="expense_category_id" class="form-label fw-semibold">
                                        ប្រភេទចំណាយ<span class="text-danger">*</span>
                                    </label>
                                    <select name="expense_category_id" id="expense_category_id"
                                        class="form-select rounded-0" required>
                                        <option value="">-- ជ្រើសរើសប្រភេទចំណាយ --</option>
                                        @foreach ($expenseCategories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('expense_category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="note" class="form-label fw-semibold">ចំណាំ</label>
                                    <textarea name="note" id="note" class="form-control rounded-0" rows="3" placeholder="ចំណាំបន្ថែម..."></textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-0 mb-3">
                        <div class="card-header bg-white py-3">
                            <h6 class="fw-bold mb-0 text-danger">សង្ខេបការបម្លែងឯកតា</h6>
                        </div>
                        <div class="card-body p-3">
                            <p class="text-muted small mb-2">ឯកតាមូលដ្ឋាន: <span id="baseUnitLabel"
                                    class="fw-bold text-dark">-</span></p>
                            <p class="text-muted small mb-3">អត្រាបម្លែង<span id="conversionFactorLabel"
                                    class="fw-bold text-dark">1</span></p>
                            <div class="alert alert-light border rounded-0 p-2 mb-3">
                                <span class="small text-muted d-block">ចំនួនសរុបគជាឯកតាមូលដ្ឋាន:</span>
                                <h5 id="totalCalculatedBaseQty" class="fw-bold text-success mb-0">0</h5>
                            </div>
                            <button type="submit" class="btn btn-primary rounded-0 w-100 mb-2">
                                <i class="bi bi-check-lg me-1"></i> រក្សាទុកស្តុក
                            </button>
                            <a href="{{ route('products.index') }}"
                                class="btn btn-secondary rounded-0 w-100">បោះបង់</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productSelect = document.getElementById('product_id');
            const unitSelect = document.getElementById('unit_id');
            const quantityInput = document.getElementById('quantity');
            const baseUnitLabel = document.getElementById('baseUnitLabel');
            const conversionFactorLabel = document.getElementById('conversionFactorLabel');
            const totalCalculatedBaseQty = document.getElementById('totalCalculatedBaseQty');

            let currentUnitOptions = [];

            productSelect.addEventListener('change', function() {
                const productId = this.value;
                unitSelect.innerHTML = '<option value="">កំពុងទាញយក...</option>';
                baseUnitLabel.textContent = '-';
                conversionFactorLabel.textContent = '1';
                totalCalculatedBaseQty.textContent = '0';
                currentUnitOptions = [];

                if (!productId) {
                    unitSelect.innerHTML = '<option value="">-- សូមជ្រើសរើសផលិតផលជាមុន --</option>';
                    return;
                }
                fetch(`{{ url('inventory-transactions/product-units') }}/${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            baseUnitLabel.textContent = data.base_unit ?
                                `${data.base_unit.name} (${data.base_unit.symbol || ''})` : '-';
                            currentUnitOptions = data.unit_options;

                            let optionsHtml = '<option value="">-- ជ្រើសរើសឯកតា --</option>';
                            data.unit_options.forEach(opt => {
                                optionsHtml +=
                                    `<option value="${opt.unit_id}" data-factor="${opt.conversion_factor}">${opt.unit.name} (${opt.unit.symbol || ''}) - បម្លែង: ${opt.conversion_factor}</option>`;
                            });
                            unitSelect.innerHTML = optionsHtml;
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        unitSelect.innerHTML = '<option value="">កំហុសក្នុងការទាញយកទិន្នន័យ</option>';
                    });
            });

            function calculateTotal() {
                const selectedOption = unitSelect.options[unitSelect.selectedIndex];
                const factor = parseFloat(selectedOption ? selectedOption.getAttribute('data-factor') : 1) || 1;
                const qty = parseFloat(quantityInput.value) || 0;

                conversionFactorLabel.textContent = factor;
                totalCalculatedBaseQty.textContent = (qty * factor).toFixed(3) + ' ' + (baseUnitLabel.textContent);
            }

            unitSelect.addEventListener('change', calculateTotal);
            quantityInput.addEventListener('input', calculateTotal);
        });
    </script>
</x-admin-layout>
