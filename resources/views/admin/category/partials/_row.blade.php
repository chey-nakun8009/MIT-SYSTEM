@forelse ($categories as $category)
    <tr data-id="{{ $category->id }}">
        <td>
            <div class="d-flex align-items-center">
                <img src="{{ $category->showPhoto() }}" class="category-image me-3" alt="{{ $category->name }}"
                    style="width:50px; height:50px;">
                <div>
                    <div class="fw-medium">{{ Str::title($category->name) }}</div>
                    <small class="text-muted">{{ $category->slug }}</small>
                </div>
            </div>
        </td>
        <td class="txt-center">{{ $category->sort_order }}</td>
        <td class="txt-center {{ $category->is_active == true ? 'text-success' : 'text-danger' }}">
            <span>{{ $category->is_active = true ? 'សកម្ម' : 'អសកម្ម' }}</span>
        </td>
        <td class="txt-start">{{ $category->description }}</td>

        <td>
            <div class="d-flex align-items-center gap-1">
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-action action-edit"
                    title="Edit User">
                    <x-svg.edit />
                </a>
                <button type="button" class="btn btn-sm btn-action action-delete btn-delete"
                    data-url="{{ route('categories.destroy', $category->id) }}" title="Delete Category">
                    <x-svg.trash />
                </button>
            </div>
        </td>
    </tr>

@empty
    <x-empty-row :colspan="7" />
@endforelse
