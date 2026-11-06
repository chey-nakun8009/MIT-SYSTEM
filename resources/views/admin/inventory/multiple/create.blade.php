<x-admin-layout>
    <div class="container-fluid px-4 py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">បញ្ចូលស្តុកទំនិញច្រើនព្រមគ្នា</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('inventory-transactions.index') }}">ប្រតិបត្តិការស្តុក</a></li>
                        <li class="breadcrumb-item active" aria-current="page">បញ្ចូលស្តុកច្រើន</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('inventory-transactions.index') }}" class="btn btn-sm btn-outline-secondary rounded-0">
                <i class="bi bi-arrow-left me-1"></i> ត្រឡប់ក្រោយ
            </a>
        </div>

        <form class="ajax-form" action="{{ route('inventory-transactions.store-multiple-item') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-0">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <label for="reference_no" class="form-label fw-semibold">លេខយោងវិក្កយបត្រ</label>
                                    <input type="text" name="reference_no" id="reference_no"
                                        class="form-control rounded-0" placeholder="INV-2026-001">
                                </div>
                                <div class="col-md-4">
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
                                <div class="col-md-6">
                                    <label for="note" class="form-label fw-semibold">ចំណាំទូទៅ</label>
                                    <input type="text" name="note" id="note" class="form-control rounded-0"
                                        placeholder="ចំណាំបន្ថែម...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-0">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 text-danger">
                                <i class="bi bi-list-check me-2"></i> បញ្ជីទំនិញទទួលចូល
                            </h6>
                            <button type="button" id="addRowBtn" class="btn btn-sm btn-success rounded-0">
                                <i class="bi bi-plus-lg me-1"></i> បន្ថែមជួរ
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0" id="itemsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 35%;">ផលិតផល<span class="text-danger">*</span>
                                            </th>
                                            <th style="width: 20%;">ឯកតា<span class="text-danger">*</span></th>
                                            <th style="width: 15%;">ចំនួន<span class="text-danger">*</span></th>
                                            <th style="width: 15%;">ថ្លៃដើម</th>
                                            <th style="width: 10%;" class="text-center">សកម្មភាព</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsTableBody">
                                        <tr class="item-row">
                                            <td>
                                                <select name="items[0][product_id]"
                                                    class="form-select product-select rounded-0" required>
                                                    <option value="">-- ជ្រើសរើសផលិតផល --</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">
                                                            {{ Str::title($product->name) }} (SKU:
                                                            {{ $product->sku }})</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="items[0][unit_id]"
                                                    class="form-select unit-select rounded-0" required>
                                                    <option value="">-- ជ្រើសរើសផលិតផលជាមុន --</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="items[0][quantity]"
                                                    class="form-control rounded-0" min="0.001" step="0.001"
                                                    placeholder="0.00" required>
                                            </td>
                                            <td>
                                                <input type="number" name="items[0][cost_price]"
                                                    class="form-control rounded-0" min="0" step="0.001"
                                                    placeholder="0.00">
                                            </td>
                                            <td class="txt-center">
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger rounded-0 remove-row-btn"
                                                    disabled>
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white py-3 text-end">
                            <button type="submit" class="btn btn-danger rounded-0 px-4">
                                <i class="bi bi-check-lg me-1"></i> រក្សាទុក
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let rowIndex = 0;
            const productsData = @json($products);

            function setupRowEvents(row) {
                const productSelect = row.querySelector('.product-select');
                const unitSelect = row.querySelector('.unit-select');

                productSelect.addEventListener('change', function() {
                    const productId = this.value;
                    unitSelect.innerHTML = '<option value="">កំពុងទាញយក...</option>';
                    if (!productId) {
                        unitSelect.innerHTML = '<option value="">-- សូមជ្រើសរើសផលិតផលជាមុន --</option>';
                        return;
                    }

                    fetch(`{{ url('inventory-transactions/product-units') }}/${productId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.status) {
                                let optionsHtml = '<option value="">-- ជ្រើសរើសឯកតា --</option>';
                                if (data.base_unit) {
                                    optionsHtml +=
                                        `<option value="${data.base_unit.id}" data-factor="1">${data.base_unit.name} (${data.base_unit.symbol || ''}) - ឯកតាមូលដ្ឋាន</option>`;
                                }

                                data.unit_options.forEach(opt => {
                                    if (!data.base_unit || opt.unit_id !== data.base_unit.id) {
                                        optionsHtml +=
                                            `<option value="${opt.unit_id}" data-factor="${opt.conversion_factor}">${opt.unit.name} (${opt.unit.symbol || ''}) - បម្លែង: ${opt.conversion_factor}</option>`;
                                    }
                                });
                                unitSelect.innerHTML = optionsHtml;
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            unitSelect.innerHTML = '<option value="">កំហុសក្នុងការទាញយក</option>';
                        });
                });

                const removeBtn = row.querySelector('.remove-row-btn');
                removeBtn.addEventListener('click', function() {
                    row.remove();
                    updateRemoveButtons();
                });
            }

            function updateRemoveButtons() {
                const rows = document.querySelectorAll('.item-row');
                rows.forEach((row, index) => {
                    const btn = row.querySelector('.remove-row-btn');
                    if (rows.length > 1) {
                        btn.removeAttribute('disabled');
                    } else {
                        btn.setAttribute('disabled', 'true');
                    }
                });
            }
            setupRowEvents(document.querySelector('.item-row'));

            // Add Row Handler
            document.getElementById('addRowBtn').addEventListener('click', function() {
                rowIndex++;
                const tbody = document.getElementById('itemsTableBody');
                const newRow = document.createElement('tr');
                newRow.classList.add('item-row');

                let productOptionsHtml = '<option value="">-- ជ្រើសរើសផលិតផល --</option>';
                productsData.forEach(p => {
                    productOptionsHtml +=
                        `<option value="${p.id}">${p.name} (SKU: ${p.sku})</option>`;
                });

                newRow.innerHTML = `
                <td>
                    <select name="items[${rowIndex}][product_id]" class="form-select product-select rounded-0" required>
                        ${productOptionsHtml}
                    </select>
                </td>
                <td>
                    <select name="items[${rowIndex}][unit_id]" class="form-select unit-select rounded-0" required>
                        <option value="">-- សូមជ្រើសរើសផលិតផលជាមុន --</option>
                    </select>
                </td>
                <td>
                    <input type="number" name="items[${rowIndex}][quantity]" class="form-control rounded-0" min="0.001" step="0.001" placeholder="0.00" required>
                </td>
                <td>
                    <input type="number" name="items[${rowIndex}][cost_price]" class="form-control rounded-0" min="0" step="0.001" placeholder="0.00">
                </td>
                <td class="txt-center">
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-0 remove-row-btn">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;

                tbody.appendChild(newRow);
                setupRowEvents(newRow);
                updateRemoveButtons();
            });
        });
    </script>
</x-admin-layout>
