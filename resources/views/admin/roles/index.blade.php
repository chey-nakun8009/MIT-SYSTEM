<x-admin-layout>
    <div class="container-fluid">
        <div class="card border-0 shadow-sm mb-2 rounded-0">
            <div
                class="bg-primary card-header text-white d-flex justify-content-between align-items-center py-1 rounded-0">
                <div class="d-flex align-items-center gap-3">
                    @if (setting('system_logo'))
                        <img src="{{ asset('uploads/settings/' . setting('system_logo')) }}"
                            alt="{{ setting('system_name', 'MTI') }}" height="40"
                            class="d-inline-block align-text-top me-2"
                            style="width: {{ setting('logo_width', 'auto') }}; height: {{ setting('logo_height', '40px') }}; border-radius: {{ setting('logo_border_radius', '0') }};">
                    @else
                        <img src="{{ asset('photos/logo_login.png') }}" alt="Logo" height="40"
                            class="d-inline-block align-text-top me-2">
                    @endif
                    <div>
                        <h5 class="mb-0 fw-bold text-white text-capitalize">ការគ្រប់គ្រងតួនាទី</h5>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-1">
                    <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm rounded-0">
                        <i class="fas fa-plus me-1"></i>បង្កើតថ្មី
                    </a>
                </div>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success rounded-0">
                {{ session('success') }}
            </div>
        @endif
        <section class="panel rounded-0 p-2">
            <div class="table-responsive rounded-0">
                <table class="table align-middle mb-0 table-custom-padding">

                    <thead class="table-header">
                        <tr>
                            <th width="60">ល.រ</th>
                            <th>ឈ្មោះតួនាទី</th>
                            <th>សិទ្ធនិងការអនុញ្ញាត្ត</th>
                            <th>Guard</th>
                            <th>ថ្ងៃខែបង្កើត</th>
                            <th class="text-center" width="100">កំណត់</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr>
                                <td>{{ $roles->firstItem() + $loop->index }}</td>
                                <td class="txt-start">{{ $role->name }}</td>
                                <td class="txt-center">{{ $role->permissions_count }}</td>
                                <td>{{ $role->guard_name }}</td>
                                <td class="txt-center">{{ $role->created_at?->format('d-m-Y') }}</td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <a href="{{ route('roles.edit', $role->id) }}"
                                            class="btn btn-sm btn-action action-edit" title="Manage Permissions">
                                            <x-svg.edit />
                                        </a>
                                        <button type="button" class="btn btn-sm btn-action action-delete btn-delete"
                                            data-url="{{ route('roles.destroy', $role->id) }}" title="Delete">
                                            <x-svg.trash />
                                        </button>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-2 text-muted border-white">
                                    <div
                                        class="d-flex flex-column align-items-center justify-content-center gap-2 py-4">
                                        <h6 class="fw-semibold mb-0"> មិនមានទិន្ន័យតួនាទីក្នុង System សូមបង្កើតថ្មី
                                        </h6>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if ($roles->hasPages())
                    <div class="d-flex justify-content-end mt-2">
                        {{ $roles->links('vendor.pagination.bootstrap-5') }}
                    </div>
                @endif
            </div>
        </section>
    </div>
</x-admin-layout>
