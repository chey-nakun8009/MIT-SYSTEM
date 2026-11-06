@forelse ($users as $user)
    <tr data-id="{{ $user->id }}">
        <td>
            <div class="d-flex align-items-center">
                <img src="{{ $user->showUserProfile() }}" class="user-image me-3 rounded-circle"
                    alt="{{ Str::title($user->first_name . ' ' . $user->last_name) }}"
                    style="width: 50px; height: 50px; object-fit: cover;">
                <div>
                    <div class="fw-medium">{{ Str::title($user->first_name . ' ' . $user->last_name) }}</div>
                    <small class="text-muted">{{ $user->email }}</small>
                </div>
            </div>
        </td>
        <td class="txt-center">{{ ucfirst($user->getRoleNames()->first() ?? 'No Role') }}</td>
        <td class="txt-center">{{ $user->phone ?? '+855' }}</td>
        <td class="txt-center {{ $user->status == 'active' ? 'text-success' : 'text-danger' }}">
            {{ $user->status == 'active' ? 'សកម្ម' : 'អសកម្ម' }}</td>
        <td class="txt-center">{{ $user->preferred_currency ?? 'KH' }}</td>
        <td class="txt-center">{{ $user->language ?? 'KH' }}</td>
        <td>
            <div class="d-flex justify-content-center gap-1 align-items-center">
                <a href="{{ route('users.edit', [
                    'user' => $user->id,
                    'page' => $users->currentPage(),
                ]) }}"
                    class="btn btn-sm btn-action btn-edit" title="Edit user">
                    <x-svg.edit />
                </a>
                <button type="button" class="btn btn-sm btn-action btn-delete"
                    data-url="{{ route('users.destroy', $user->id) }}" data-page="{{ $users->currentPage() }}"
                    title="Delete user">
                    <x-svg.trash />
                </button>
            </div>
        </td>
    </tr>
@empty
    <x-empty-row :colspan="7" />
@endforelse
