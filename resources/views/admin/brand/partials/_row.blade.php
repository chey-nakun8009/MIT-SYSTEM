@forelse ($brands as $brand)
    <tr data-id="{{ $brand->id }}">
        <td>
            <img src="{{ $brand->showBrandLogo() }}" class="user-image rounded-0" alt="{{ $brand->name }}"
                style="width: 50px; height: 50px; object-fit: cover;">
        </td>

        <td class="txt-start">
            {{ Str::title($brand->name) }}
        </td>
        <td class="txt-start">
            {{ $brand->description ? Str::limit($brand->description, 60) : '-' }}
        </td>
        <td class="txt-center">
            @if ($brand->is_active)
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
            {{ $brand->sort_order }}
        </td>
        <td class="col-action">
            <div class="d-flex justify-content-center gap-1 align-items-center">

                <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-sm btn-action btn-edit"
                    title="Edit brand">
                    <x-svg.edit />
                </a>

                <button type="button" class="btn btn-sm btn-action btn-delete"
                    data-url="{{ route('brands.destroy', $brand->id) }}" data-page="{{ $brands->currentPage() }}"
                    title="Delete brand">
                    <x-svg.trash />
                </button>

            </div>
        </td>

    </tr>
@empty
    <x-empty-row :colspan="7" />
@endforelse
