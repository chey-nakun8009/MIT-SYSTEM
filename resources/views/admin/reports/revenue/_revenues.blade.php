@extends('admin.reports.index')
@section('settings_content')
    <!-- Filter Bar -->
    <div class="card bg-light border-0 p-3 mb-4 rounded-0 d-print-none">
        <form method="GET" action="{{ route('reports.revenues') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">កាលបរិច្ឆេទចាប់ពី</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                    class="form-control form-control-sm rounded-0">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">ដល់កាលបរិច្ឆេទ</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                    class="form-control form-control-sm rounded-0">
            </div>
            <div class="col-md-6 d-flex gap-2">
                <button type="submit" class="btn btn-xs btn-dark rounded-0 px-3">
                    <i class="bi bi-filter me-1"></i> ស្វែងរក
                </button>
                <a href="{{ route('reports.revenues') }}" class="btn btn-xs btn-outline-secondary rounded-0">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> សម្អាត
                </a>
            </div>
        </form>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card bg-white p-3 border-0 border-start border-4 border-success shadow-sm rounded-0">
                <span class="text-muted small text-uppercase fw-semibold">ចំណូលសរុប</span>
                <h4 class="fw-bold text-success mb-0 mt-1">${{ number_format($totalRevenue, 3) }}</h4>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-white p-3 border-0 border-start border-4 border-info shadow-sm rounded-0">
                <span class="text-muted small text-uppercase fw-semibold">ចំនួនកំណត់ត្រាសរុប</span>
                <h4 class="fw-bold text-info mb-0 mt-1">{{ number_format($totalRecords ?? $revenues->count()) }}</h4>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-success mb-0">របាយការណ៍ចំណូល</h5>
    </div>
    <form action="{{ route('reports.revenues.print-selected') }}" method="POST" target="_blank" id="printSelectedForm"
        onsubmit="return validatePrintSelection(event)">
        @csrf
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="form-check">
                <input class="form-check-input rounded-0" type="checkbox" id="selectAll">
                <label class="form-check-label small fw-bold text-muted" for="selectAll">ជ្រើសរើសទាំងអស់</label>
            </div>
            <button type="submit" class="btn btn-xs btn-outline-success rounded-0">
                <i class="bi bi-printer me-1"></i> បោះពុម្ព
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40px;" class="text-center">#</th>
                        <th style="width: 50px !important;" class="txt-center">ល.រ</th>
                        <th>វិក័យបត្រ</th>
                        <th class="txt-start">ប្រភេទចំណូល</th>
                        <th class="txt-start">កំណត់ចំណាំ</th>
                        <th>កាលបរិច្ឆេទ</th>
                        <th class="txt-center">ទឹកប្រាក់</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($revenues as $revenue)
                        <tr>
                            <td class="text-center">
                                <input class="form-check-input row-checkbox rounded-0" type="checkbox" name="ids[]"
                                    value="{{ $revenue->id }}">
                            </td>
                            <td class="txt-center" style="width: 50px !important;">{{ $loop->iteration }}</td>
                            <td class="txt-center">{{ $revenue->reference_no ?? 'N/A' }}</td>
                            <td class="txt-start">
                                {{ $revenue->category->name ?? 'General' }}
                            </td>
                            <td class="txt-start">{{ Str::limit($revenue->note, 100) }}</td>
                            <td class="txt-center" style="width: 180px !important;">
                                {{ $revenue->created_at->format('Y-m-d') }}</td>
                            <td class="txt-center fw-semibold text-success">
                                +${{ number_format($revenue->amount, 3) }}
                            </td>
                        </tr>
                    @empty
                        <x-empty-row :colspan="7" />
                    @endforelse
                </tbody>
            </table>
        </div>
    </form>

    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.row-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        function validatePrintSelection(event) {
            let checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
            if (checkedBoxes.length === 0) {
                alert('សូមជ្រើសរើសប្រតិបត្តិការយ៉ាងតិច១ ដើម្បីបោះពុម្ព។');
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
@endsection
