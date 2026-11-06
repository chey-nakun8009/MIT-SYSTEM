@forelse ($suppliers as $supplier)
    <tr data-id="{{ $supplier->id }}">
        <td>
            <input type="checkbox" class="form-check-input user-checkbox" value="{{ $supplier->id }}">
        </td>
        <td>{{ Str::title($supplier->name) }}</td>
        <td class="text-success">{{ $supplier->email }}</td>
        <td class="col-contact">{{ $supplier->phone }}</td>
        <td>{{ $supplier->address }}</td>
        <td class="col-contact text-danger">{{ $supplier->tax_number }}</td>


        <td class="txt-center align-middle">
            <span class="badge px-3 py-2 rounded-0 {{ $supplier->is_active ? 'bg-success' : 'bg-danger' }}">
                {{ $supplier->is_active ? 'សកម្ម' : 'អសកម្ម' }}
            </span>
        </td>
        <td class="txt-start">{{ $supplier->notes }}</td>
        <td class="col-action">
            <div class="d-flex justify-content-center gap-1 align-items-center">
                <a href="{{ route('suppliers.edit', ['supplier' => $supplier->id, 'page' => $suppliers->currentPage()]) }}"
                    class="btn btn-sm btn-action btn-edit" title="Edit Supplier">
                    <x-svg.edit />
                </a>
                <button type="button" class="btn btn-sm btn-action btn-delete"
                    data-url="{{ route('suppliers.destroy', $supplier->id) }}"
                    data-page="{{ $suppliers->currentPage() }}" title="Delete Supplier">
                    <x-svg.trash />
                </button>
            </div>
        </td>
    </tr>

@empty
    <tr>
        <td colspan="9" class="text-center py-5">
            <div class="d-flex flex-column align-items-center justify-content-center text-muted">
                <i class="bi bi-people fs-1 mb-2"></i>
                <div class="fw-semibold">No suppliers found</div>
                <small>There are no suppliers available at the moment.</small>
            </div>
        </td>
    </tr>
@endforelse
