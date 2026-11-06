@forelse ($attributes as $attribute)
    <tr data-id="{{ $attribute->id }}">

        <td>
            <input type="checkbox" class="form-check-input">
        </td>

        <td class="txt-start">
            {{ Str::title($attribute->name) }}
        </td>

        <td class="txt-center">
            @if ($attribute->is_active)
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
            {{ $attribute->sort_order }}
        </td>

        <td class="col-action">
            <div class="d-flex justify-content-center gap-1 align-items-center">

                <a href="{{ route('attributes.values.index', [
                    'attribute' => $attribute->id,
                    'page' => $attributes->currentPage(),
                ]) }}"
                    class="btn btn-sm btn-action" title="Manage values">
                    <i class="bi bi-list-ul"></i>
                </a>

                <a href="{{ route('attributes.edit', [
                    'attribute' => $attribute->id,
                    'page' => $attributes->currentPage(),
                ]) }}"
                    class="btn btn-sm btn-action btn-edit" title="Edit attribute">
                    <x-svg.edit />
                </a>

                <button type="button" class="btn btn-sm btn-action btn-delete"
                    data-url="{{ route('attributes.destroy', $attribute->id) }}"
                    data-page="{{ $attributes->currentPage() }}" title="Delete attribute">
                    <x-svg.trash />
                </button>

            </div>
        </td>

    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center py-5">
            <div class="d-flex flex-column align-items-center justify-content-center text-muted">
                <i class="bi bi-sliders fs-1 mb-2"></i>

                <div class="fw-semibold">
                    {{ __('attribute.no_attribute') }}
                </div>

                <small>
                    {{ __('attribute.no_attribute_description') }}
                </small>
            </div>
        </td>
    </tr>
@endforelse
