<x-admin-layout>
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="mb-1">កែសម្រួលសិទ្ធនិងលក្ខខណ្ឌ</h5>
                <small class="text-muted">
                    កំណត់លក្ខខណ្ឌផ្សេងៗសម្រាប់​ {{ ucfirst($role->name) }}
                </small>
            </div>

            <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm rounded-0">
                <i class="fas fa-arrow-left me-1"></i> ត្រឡប់ក្រោយ
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger rounded-0">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card border-0 shadow-sm rounded-0 mb-3">
                <div class="card-body">

                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                ឈ្មោះតួនាទី(Role)
                            </label>
                            <input type="text" class="form-control rounded-0" value="{{ ucfirst($role->name) }}"
                                readonly>
                        </div>

                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            {{ count($assignedPermissions) }} សិទ្ធចំនួនត្រូវបានកំណត់ឲ្យ
                        </div>
                    </div>

                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">បញ្ជីសិទ្ធិប្រើប្រាស់</h6>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-0" id="selectAllPermissions"
                        style="cursor:pointer">
                        Select All
                    </button>

                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-0" id="clearAllPermissions"
                        style="cursor:pointer">
                        Clear All
                    </button>
                </div>
            </div>

            <div class="row">

                @foreach ($permissionGroups as $module => $actions)
                    <div class="col-xl-6 col-12 mb-3">

                        <div class="card border-0 shadow-sm rounded-0 h-100">

                            <div class="card-header bg-light d-flex justify-content-between align-items-center">

                                <span class="fw-semibold text-capitalize">
                                    {{ str_replace('_', ' ', $module) }}
                                </span>

                                <div class="form-check mb-0">
                                    <input type="checkbox" class="form-check-input module-select-all"
                                        id="module-{{ $module }}" data-module="{{ $module }}">

                                    <label class="form-check-label small" for="module-{{ $module }}"
                                        style="cursor:pointer">
                                        Select All
                                    </label>
                                </div>

                            </div>

                            <div class="card-body">

                                <div class="row g-3">

                                    @foreach ($actions as $action => $label)
                                        @php
                                            $permissionName = $module . '.' . $action;
                                            $checked = in_array(
                                                $permissionName,
                                                old('permissions', $assignedPermissions),
                                            );
                                        @endphp

                                        <div class="col-6 col-md-4">

                                            <div class="form-check">

                                                <input type="checkbox"
                                                    class="form-check-input permission-checkbox border "
                                                    name="permissions[]" value="{{ $permissionName }}"
                                                    id="permission-{{ $module }}-{{ $action }}"
                                                    data-module="{{ $module }}" @checked($checked)>

                                                <label class="form-check-label"
                                                    for="permission-{{ $module }}-{{ $action }}">
                                                    {{ $label }}
                                                </label>

                                            </div>

                                        </div>
                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

            <div class="card border-0 shadow-sm rounded-0">
                <div class="card-body d-flex justify-content-end gap-2">

                    <a href="{{ route('roles.index') }}" class="btn btn-light rounded-0">
                        បោះបង់
                    </a>

                    <button type="submit" class="btn btn-primary rounded-0">
                        <i class="fas fa-save me-1"></i>
                        រក្សាទុក
                    </button>

                </div>
            </div>

        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const checkboxes = document.querySelectorAll('.permission-checkbox');
            const moduleSelectAll = document.querySelectorAll('.module-select-all');

            function updateModuleCheckbox(module) {
                const items = document.querySelectorAll(
                    '.permission-checkbox[data-module="' + module + '"]'
                );

                const selectAll = document.querySelector(
                    '.module-select-all[data-module="' + module + '"]'
                );

                const checkedCount = [...items].filter(item => item.checked).length;

                selectAll.checked = checkedCount === items.length;
                selectAll.indeterminate = checkedCount > 0 && checkedCount < items.length;
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateModuleCheckbox(this.dataset.module);
                });
            });

            moduleSelectAll.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const module = this.dataset.module;

                    document.querySelectorAll(
                        '.permission-checkbox[data-module="' + module + '"]'
                    ).forEach(item => {
                        item.checked = this.checked;
                    });

                    this.indeterminate = false;
                });
            });

            document.getElementById('selectAllPermissions')
                .addEventListener('click', function() {
                    checkboxes.forEach(item => item.checked = true);
                    moduleSelectAll.forEach(item => {
                        item.checked = true;
                        item.indeterminate = false;
                    });
                });

            document.getElementById('clearAllPermissions')
                .addEventListener('click', function() {
                    checkboxes.forEach(item => item.checked = false);
                    moduleSelectAll.forEach(item => {
                        item.checked = false;
                        item.indeterminate = false;
                    });
                });

            moduleSelectAll.forEach(item => {
                updateModuleCheckbox(item.dataset.module);
            });

        });
    </script>
</x-admin-layout>
