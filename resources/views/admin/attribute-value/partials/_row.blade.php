@forelse ($values as $value)
    <tr data-id="{{ $value->id }}">

        <td>
            <input type="checkbox" class="form-check-input">
        </td>

        <td class="txt-start">
            {{ Str::title($value->value) }}
        </td>

        <td class="txt-center">
            @if ($value->is_active)
                <span class="badge px-3 py-2 rounded-0 bg-success">
                    Active
                </span>
            @else
                <span class="badge px-3 py-2 rounded-0 bg-danger">
                    Inactive
                </span>
            @endif
        </td>

        <td class="txt-center">
            {{ $value->sort_order }}
        </td>

        <td class="col-action">
            <div class="d-flex justify-content-center gap-1 align-items-center">

                <a href="{{ route('attributes.values.edit', [
                    'attribute' => $attribute->id,
                    'value' => $value->id,
                    'page' => $values->currentPage(),
                ]) }}"
                    class="btn btn-sm btn-action btn-edit"
                    title="Edit value">
                    <x-svg.edit />
                </a>

                <button
                    type="button"
                    class="btn btn-sm btn-action btn-delete"
                    data-url="{{ route('attributes.values.destroy', [
                        'attribute' => $attribute->id,
                        'value' => $value->id,
                    ]) }}"
                    data-page="{{ $values->currentPage() }}"
                    title="Delete value">
                    <x-svg.trash />
                </button>

            </div>
        </td>

    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center py-5">
            <div class="d-flex flex-column align-items-center justify-content-center text-muted">

                <i class="bi bi-list-ul fs-1 mb-2"></i>

                <div class="fw-semibold">
                    No values found
                </div>

                <small>
                    There are no values available for this attribute.
                </small>
            </div>
        </td>
    </tr>
@endforelse