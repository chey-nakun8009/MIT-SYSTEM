@extends('layouts.settings')
@section('settings_content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-dark mb-0">ប្រភេទចំណាយ</h5>
        <div class="d-flex align-items-center gap-3">
            <x-per-page-selector :route="route('expense-categories.index')" />

            <a title="Create Revenue Category" href="{{ route('expense-categories.create') }}"
                class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 rounded-0">
                <x-svg.add /> <span class="d-none d-md-inline">បង្កើតថ្មី</span>
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 table-custom-padding">
            <thead class="table-header">
                <tr>
                    <th class="bg-primary text-center">ល.រ</th>
                    <th class="bg-primary" style="text-align: start !important;">ឈ្មោះប្រភេទចំណាយ</th>
                    <th class="bg-primary text-center">ស្ថានភាព</th>
                    <th class="bg-primary text-center cursor-pointer" class="text-end"
                        style="width: 80px"title="click to select all or deselect">កំណត់</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenseCategories as $category)
                    <tr>
                        <td style="width: 50px; max-width:50px; min-width:50px;">{{ $loop->iteration }}</td>
                        <td class="txt-start">{{ $category->name }}</td>
                        <td style="width: 120px;">
                            @if ($category->active)
                                <span class="text-success px-2 py-1">សកម្ម</span>
                            @else
                                <span class="text-danger px-2 py-1">អសកម្ម</span>
                            @endif
                        </td>
                        <td class="action-cell">
                            <div class="d-flex align-items-center justify-content-center gap-1">
                                <a href="{{ route('expense-categories.edit', $category) }}"
                                    class="btn btn-sm btn-action action-edit" title="Edit">
                                    <x-svg.edit />
                                </a>
                                <button type="button" class="btn btn-sm btn-action action-edit copy-btn"
                                    data-url="{{ route('expense-categories.copy', $category) }}" title="Copy">
                                    <x-svg.copy />
                                </button>
                                <button type="button" class="btn btn-sm btn-action action-delete btn-delete"
                                    data-url="{{ route('expense-categories.destroy', $category) }}" title="Delete">
                                    <x-svg.trash />
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <x-empty-row :colspan="5" />
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($expenseCategories->hasPages())
        <div class="d-flex justify-content-end mt-2">
            {{ $expenseCategories->links('vendor.pagination.bootstrap-5') }}
        </div>
    @endif
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', function() {
                const url = this.getAttribute('data-url');
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                    'content');
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            if (data.redirect) {
                                window.location.href = data.redirect;
                            } else {
                                location.reload();
                            }
                        } else {
                            alert(data.message || 'Something went wrong.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while copying.');
                    });
            });
        });
    });
</script>
