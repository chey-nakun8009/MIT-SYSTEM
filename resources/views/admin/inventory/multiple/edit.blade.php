<x-admin-layout>
    <div class="container-fluid px-4 py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">កែប្រែការនាំចូលស្តុកច្រើន</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('inventory-transactions.index') }}">ប្រតិបត្តិការស្តុក</a></li>
                        <li class="breadcrumb-item active" aria-current="page">កែប្រែច្រើន</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('inventory-transactions.index') }}" class="btn btn-sm btn-outline-secondary rounded-0">
                <i class="bi bi-arrow-left me-1"></i> ត្រឡប់ក្រោយ
            </a>
        </div>

        <form class="ajax-form" action="{{ route('inventory-transactions.update-multiple') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="reference_no" value="{{ $referenceNo }}">

            <div class="row g-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-0">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">លេខយោងវិក្កយបត្រ</label>
                                    <input type="text" class="form-control rounded-0 bg-light"
                                        value="{{ $referenceNo }}" disabled>
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
                                                {{ old('expense_category_id', optional($linkedExpense)->expense_category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="note" class="form-label fw-semibold">ចំណាំទូទៅ</label>
                                    <input type="text" name="note" id="note" class="form-control rounded-0"
                                        value="{{ $transactions->first()->note ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-0">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 text-danger">
                                <i class="bi bi-list-check me-2"></i> បញ្ជីទំនិញ
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
                                            <th style="width: 35%;">ផលិតផល <span class="text-danger">*</span></th>
                                            <th style="width: 20%;">ឯកតា <span class="text-danger">*</span></th>
                                            <th style="width: 15%;">ចំនួន <span class="text-danger">*</span></th>
                                            <th style="width: 15%;">ថ្លៃដើម</th>
                                            <th style="width: 10%;" class="text-center">សកម្មភាព</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsTableBody">
                                        @foreach ($transactions as $index => $tx)
                                            <tr class="item-row">
                                                <td>
                                                    <select name="items[{{ $index }}][product_id]"
                                                        class="form-select product-select rounded-0" required>
                                                        <option value="">-- ជ្រើសរើសផលិតផល --</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                {{ $tx->product_id == $product->id ? 'selected' : '' }}>
                                                                {{ $product->name }} (SKU: {{ $product->sku }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="items[{{ $index }}][unit_id]"
                                                        class="form-select unit-select rounded-0" required>
                                                        <option value="{{ $tx->unit_id }}">
                                                            {{ $tx->unit->name ?? 'Current Unit' }}
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="items[{{ $index }}][quantity]"
                                                        class="form-control rounded-0" min="0.001" step="0.001"
                                                        value="{{ $tx->quantity }}" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="items[{{ $index }}][cost_price]"
                                                        class="form-control rounded-0" min="0" step="0.001"
                                                        value="{{ $tx->cost_price }}">
                                                </td>
                                                <td class="text-center">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger rounded-0 remove-row-btn">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
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
            let rowIndex = {{ count($transactions) }};
            const productsData = @json($products);

            function fetchUnitsForProduct(productSelect, selectedUnitId = null) {
                const productId = productSelect.value;
                const row = productSelect.closest('tr');
                const unitSelect = row.querySelector('.unit-select');

                if (!productId) {
                    unitSelect.innerHTML = '<option value="">-- ជ្រើសរើសឯកតា --</option>';
                    return;
                }

                fetch(`{{ url('inventory-transactions/product-units') }}/${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            let optionsHtml = '<option value="">-- ជ្រើសរើសឯកតា --</option>';

                            if (data.base_unit) {
                                const isSelected = selectedUnitId == data.base_unit.id ? 'selected' : '';
                                optionsHtml +=
                                    `<option value="${data.base_unit.id}" ${isSelected}>${data.base_unit.name} (${data.base_unit.symbol || ''}) - ឯកតាមូលដ្ឋាន</option>`;
                            }

                            data.unit_options.forEach(opt => {
                                if (!data.base_unit || opt.unit_id !== data.base_unit.id) {
                                    const isSelected = selectedUnitId == opt.unit_id ? 'selected' : '';
                                    optionsHtml +=
                                        `<option value="${opt.unit_id}" ${isSelected}>${opt.unit.name} (${opt.unit.symbol || ''})</option>`;
                                }
                            });

                            unitSelect.innerHTML = optionsHtml;
                        }
                    })
                    .catch(err => console.error(err));
            }
            document.getElementById('itemsTableBody').addEventListener('change', function(e) {
                if (e.target && e.target.classList.contains('product-select')) {
                    fetchUnitsForProduct(e.target);
                }
            });
            document.querySelectorAll('.item-row').forEach(row => {
                const productSelect = row.querySelector('.product-select');
                const unitSelect = row.querySelector('.unit-select');
                if (productSelect && productSelect.value) {
                    const currentSelectedUnit = unitSelect.value;
                    fetchUnitsForProduct(productSelect, currentSelectedUnit);
                }
            });
            document.getElementById('addRowBtn').addEventListener('click', function() {
                let optionsProducts = '<option value="">-- ជ្រើសរើសផលិតផល --</option>';
                productsData.forEach(p => {
                    optionsProducts += `<option value="${p.id}">${p.name} (SKU: ${p.sku})</option>`;
                });

                const newRow = document.createElement('tr');
                newRow.className = 'item-row';
                newRow.innerHTML = `
                    <td>
                        <select name="items[${rowIndex}][product_id]" class="form-select product-select rounded-0" required>
                            ${optionsProducts}
                        </select>
                    </td>
                    <td>
                        <select name="items[${rowIndex}][unit_id]" class="form-select unit-select rounded-0" required>
                            <option value="">-- ជ្រើសរើសឯកតា --</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="items[${rowIndex}][quantity]" class="form-control rounded-0" min="0.001" step="0.001" value="1" required>
                    </td>
                    <td>
                        <input type="number" name="items[${rowIndex}][cost_price]" class="form-control rounded-0" min="0" step="0.001" placeholder="0.000">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger rounded-0 remove-row-btn">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                `;
                document.getElementById('itemsTableBody').appendChild(newRow);
                rowIndex++;
            });
            document.getElementById('itemsTableBody').addEventListener('click', function(e) {
                if (e.target.closest('.remove-row-btn')) {
                    const row = e.target.closest('tr');
                    if (document.querySelectorAll('.item-row').length > 1) {
                        row.remove();
                    } else {
                        alert('ត្រូវមានទំនិញយ៉ាងតិច១ជួរ។');
                    }
                }
            });
        });
    </script>
</x-admin-layout>
