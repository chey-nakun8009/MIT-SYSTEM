@forelse ($units as $unit)
    <tr data-id="{{ $unit->id }}">
        <td class="txt-center">{{ $loop->iteration }}</td>
        <td class="txt-start">{{ Str::title($unit->name) }}</td>
        <td class="txt-center">{{ $unit->symbol }}</td>
        <td class="txt-center">{{ $unit->type }}</td>
        <td class="txt-center">{{ $unit->decimal_places }}</td>
        <td class="col-action">
            <div class="d-flex justify-content-center gap-1 align-items-center">
                <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-sm btn-action btn-edit" title="Edit unit">
                    <x-svg.edit />
                </a>

                <button type="button" class="btn btn-sm btn-action btn-delete"
                    data-url="{{ route('units.destroy', $unit->id) }}" data-page="{{ $units->currentPage() }}"
                    title="Delete unit">
                    <x-svg.trash />
                </button>
            </div>
        </td>
    </tr>
@empty
    <x-empty-row :colspan="6" />
@endforelse
