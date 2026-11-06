<div class="card border-0 shadow-sm rounded-0">
    <div class="card-body">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div>
                <h5 class="mb-1 fw-semibold">Attributes</h5>
                <p class="text-muted mb-0 small">
                    Manage attributes and their available values.
                </p>
            </div>

            <a href="{{ route('attributes.create') }}" class="btn btn-sm rounded-0"
                style="background-color:#6f4e37;color:#fff;">
                <i class="bi bi-plus-lg me-1"></i>
                Add Attribute
            </a>
        </div>

        <div class="mb-3">
            <div class="input-group input-group-sm" style="max-width:400px;">
                <span class="input-group-text bg-white rounded-0">
                    <i class="bi bi-search"></i>
                </span>

                <input type="text" id="attribute-search" class="form-control rounded-0"
                    placeholder="Search attributes...">
            </div>
        </div>

        <div class="row g-3">

            @forelse ($attributes ?? [] as $attribute)

                <div class="col-xl-4 col-lg-6">

                    <div class="border rounded-0 h-100 p-3">

                        <div class="d-flex justify-content-between align-items-start">

                            <div>
                                <h6 class="mb-1 fw-semibold">
                                    <i class="bi bi-sliders me-1" style="color:#6f4e37;"></i>

                                    {{ $attribute->name }}
                                </h6>

                                <small class="text-muted">
                                    {{ $attribute->values->count() }} values
                                </small>
                            </div>

                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-action" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end rounded-0">

                                    <li>
                                        <a class="dropdown-item" href="{{ route('attributes.edit', $attribute->id) }}">
                                            <i class="bi bi-pencil me-2"></i>
                                            Edit
                                        </a>
                                    </li>

                                    <li>
                                        <button type="button" class="dropdown-item delete-item"
                                            data-url="{{ route('attributes.destroy', $attribute->id) }}">
                                            <i class="bi bi-trash me-2"></i>
                                            Delete
                                        </button>
                                    </li>

                                </ul>
                            </div>

                        </div>

                        <hr>

                        <div class="d-flex flex-wrap gap-1">

                            @forelse ($attribute->values as $value)
                                <span class="badge bg-light text-dark border rounded-0">
                                    {{ $value->value }}
                                </span>

                            @empty

                                <span class="text-muted small">
                                    No values
                                </span>
                            @endforelse

                        </div>

                        <div class="mt-3">
                            @if ($attribute->is_active)
                                <span class="badge bg-success-subtle text-success rounded-0">
                                    Active
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary rounded-0">
                                    Inactive
                                </span>
                            @endif
                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12">
                    <div class="text-center py-5">

                        <i class="bi bi-sliders fs-1 text-muted"></i>

                        <h6 class="mt-3">
                            No attributes found
                        </h6>

                        <p class="text-muted small">
                            Create your first product attribute.
                        </p>

                    </div>
                </div>

            @endforelse

        </div>

    </div>
</div>
