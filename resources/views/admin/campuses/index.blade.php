<x-admin-layout>
    <div class="container-fluid">
        <div class="page-header mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="page-header-icon d-flex align-items-center justify-content-center">
                        @if (setting('system_logo'))
                            <img src="{{ asset('storage/uploads/settings/' . setting('system_logo')) }}"
                                alt="{{ setting('system_name', 'Mkot Glass') }}" class="d-block"
                                style="width: {{ setting('logo_width', 'auto') }};
                                height: {{ setting('logo_height', '40px') }};
                                border-radius: {{ setting('logo_border_radius', '0') }};">
                        @else
                            <img src="{{ asset('photos/login_logo.png') }}" alt="Logo" height="40" class="d-block">
                        @endif
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">
                            សាខាសាលា
                        </h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('campuses.index') }}">
                                        សាខា
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    បង្កើតសាខាថ្មីដើម្បីគ្រប់គ្រង
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <a href="{{ route('campuses.create') }}" class="btn btn-xs btn-primary rounded-0 px-3">
                    <i class="bi bi-plus-lg"></i>
                    បង្កើតថ្មី
                </a>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="txt-start">ឈ្មោះសាខា</th>
                            <th class="txt-start">អុីមែល</th>
                            <th class="txt-start">លេខទូរស័ព្ទ</th>
                            <th class="txt-center" style="width: 150px;">ស្ថានភាព</th>
                            <th class="txt-center" style="width: 150px;">រូបិយវិត្ថ</th>
                            <th class="txt-center" style="width: 150px;">តំបន់</th>
                            <th class="txt-center" style="width: 150px;">ភាសា</th>
                            <th style="width: 120px;">គ្រប់គ្រង</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($campuses as $campus)
                            <tr data-id="{{ $campus->id }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $campus->showCampusLogo() }}" class="category-image me-3"
                                            alt="{{ $campus->name }}" style="width:50px; height:50px;">
                                        <div>
                                            <div class="fw-medium">{{ Str::title($campus->name) }}</div>
                                            <small class="text-muted">{{ $campus->slug }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="txt-start text-success">
                                    {{ $campus->email }}
                                </td>
                                <td class="txt-start">
                                    {{ $campus->phone }}
                                </td>
                                <td
                                    class="txt-center {{ $campus->status === 'active' ? 'text-success' : 'text-danger' }}">
                                    {{ ucfirst($campus->status) }}
                                </td>
                                <td class="txt-center">
                                    {{ $campus->currency }}
                                </td>
                                <td class="txt-center">
                                    {{ $campus->timezone }}
                                </td>
                                <td class="txt-center">
                                    {{ $campus->locale }}
                                </td>
                                <td class="txt-center">
                                    <div class="d-flex align-items-center gap-1">
                                        <a href="{{ route('campuses.edit', $campus) }}"
                                            class="btn btn-sm btn-action action-edit" title="Edit User">
                                            <x-svg.edit />
                                        </a>
                                        <button type="button" class="btn btn-sm btn-action action-delete btn-delete"
                                            data-url="{{ route('campuses.destroy', $campus) }}"
                                            title="Delete Category">
                                            <x-svg.trash />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <x-empty-row :colspan="5" />
                        @endforelse
                    </tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $campuses->links() }}
        </div>
    </div>
</x-admin-layout>
