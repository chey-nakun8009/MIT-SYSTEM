<x-admin-layout>
    <div class="container-fluid px-4 py-3">

        <!-- Wrap the header actions & table inside the form -->
        <form action="{{ route('inventory-transactions.print-selected') }}" method="POST" target="_blank"
            id="bulkPrintForm">
            @csrf

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">ប្រតិបត្តិការស្តុក</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">ផលិតផល</a></li>
                            <li class="breadcrumb-item active" aria-current="page">ប្រតិបត្តិការស្តុក</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('inventory-transactions.create') }}"
                        class="btn btn-sm btn-success rounded-0 text-white fw-bold">
                        <i class="bi bi-plus-lg me-1"></i> បញ្ចូលស្តុកម្ដងមួយ
                    </a>
                    <a href="{{ route('inventory-transactions.import-multiple-create') }}"
                        class="btn btn-sm btn-info rounded-0 fw-bold text-white">
                        <i class="bi bi-plus-lg me-1"></i> បញ្ចូលស្តុកម្ដងច្រើន
                    </a>
                    <!-- Changed to type="submit" so it triggers the form submission -->
                    <button type="submit" class="btn btn-secondary btn-sm rounded-0" id="printSelectedBtn" disabled>
                        <i class="bi bi-printer me-1"></i> បោះពុម្ព(<span id="selectedCount">0</span>)
                    </button>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-0 mb-3">
                <div class="card-body p-3">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <div class="input-group input-group-sm rounded-0">
                                <input id="searchInput" type="text" name="search" class="form-control rounded-0"
                                    placeholder="ស្វែងរក SKU, ឈ្មោះទំនិញ, លេខយោង..." value="{{ request('search') }}">
                                <button class="btn btn-outline-secondary rounded-0" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                                @if (request('search'))
                                    <a href="{{ route('inventory-transactions.index') }}"
                                        class="btn btn-outline-danger rounded-0">សម្អាត</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-0">
                <div class="card-body p-0">
                    @include('admin.inventory.partials._group')
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const printSelectedBtn = document.getElementById('printSelectedBtn');
            const selectedCountSpan = document.getElementById('selectedCount');
            function updateButtonState() {
                const checkedCount = document.querySelectorAll('.transaction-checkbox:checked').length;
                selectedCountSpan.textContent = checkedCount;
                printSelectedBtn.disabled = checkedCount === 0;
            }
            document.addEventListener('change', function(e) {
                if (e.target && e.target.id === 'selectAll') {
                    const checkboxes = document.querySelectorAll('.transaction-checkbox');
                    checkboxes.forEach(cb => cb.checked = e.target.checked);
                    updateButtonState();
                }
                if (e.target && e.target.classList.contains('transaction-checkbox')) {
                    const selectAll = document.getElementById('selectAll');
                    const checkboxes = document.querySelectorAll('.transaction-checkbox');
                    updateButtonState();

                    if (selectAll) {
                        if (!e.target.checked) {
                            selectAll.checked = false;
                        } else if (document.querySelectorAll('.transaction-checkbox:checked').length ===
                            checkboxes.length) {
                            selectAll.checked = true;
                        }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
