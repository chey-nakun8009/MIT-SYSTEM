<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <title>របាយការណ៍នាំចូលស្តុក - {{ $referenceNo ?? 'General' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('photos/school_logo.jpg') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Content:wght@400;700&display=swap');

        body {
            font-family: 'Content', 'Khmer OS Battambang', sans-serif;
            background: #fff;
            color: #000;
            margin: 0;
            padding: 0;
        }

        @page {
            size: A4;
            margin: 5mm;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                padding: 0;
                margin: 0;
            }

            .container {
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
        }
    </style>
</head>

<body class="py-4">
    <div class="container">
        <div class="d-flex justify-content-end align-items-center mb-4 no-print gap-3">
            <a href="{{ route('inventory-transactions.index') }}" class="btn btn-secondary btn-sm rounded-0">
                <i class="bi bi-arrow-left"></i> ត្រឡប់ក្រោយ
            </a>
            <button onclick="window.print()" class="btn btn-primary btn-sm rounded-0">
                <i class="bi bi-printer"></i> បោះពុម្ព/ទាញយក PDF
            </button>
        </div>
        <div class="mb-4 pb-3" style="border-bottom: 2px solid #6f4e37;">
            <div class="d-flex align-items-center">
                <div class="text-center" style="width: 100px; flex-shrink: 0;">
                    @if (setting('system_logo'))
                        <img src="{{ asset('uploads/settings/' . setting('system_logo')) }}" alt="School Logo"
                            style="width: 85px; height: 85px; object-fit: contain;">
                    @endif
                </div>
                <div class="flex-grow-1 text-center">
                    <h3 class="fw-bold mb-1">
                        {{ $campus->name ?? 'MTI SCHOOL' }}
                    </h3>
                    <h5 class="fw-bold mb-2" style="color: #6f4e37;">
                        របាយការណ៍ទទួលទំនិញចូលស្តុក
                    </h5>
                    @if ($referenceNo)
                        <p class="text-muted mb-1">
                            លេខយោងវិក្កយបត្រ:
                            <strong>{{ $referenceNo }}</strong>
                        </p>
                    @endif
                    <p class="text-muted small mb-0">
                        កាលបរិច្ឆេទបោះពុម្ព: {{ now()->format('d-m-Y') }}
                    </p>
                </div>
                <div style="width: 100px; flex-shrink: 0;"></div>
            </div>
        </div>
        <hr>
        @if ($expense)
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="border p-3 bg-light">
                        <p class="mb-1"><strong>ប្រភេទចំណាយ:</strong> {{ optional($expense->category)->name ?? '-' }}
                        </p>
                        <p class="mb-0"><strong>ទឹកប្រាក់ចំណាយសរុប:</strong> <span
                                class="text-danger fw-bold">${{ number_format($expense->amount, 3) }}</span></p>
                    </div>
                </div>
            </div>
        @endif
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th class="text-center text-white bg-primary" style="width: 5%;">ល.រ</th>
                    <th class="text-white bg-primary">ផលិតផល</th>
                    <th class="text-white bg-primary text-center">ឯកតា</th>
                    <th class="text-center text-white bg-primary"></th>
                    <th class="text-center text-white bg-primary">ថ្លៃដើម</th>
                    <th class="text-center text-white bg-primary">សរុប</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach ($transactions as $index => $tx)
                    @php
                        $totalCost = ($tx->quantity ?? 0) * ($tx->cost_price ?? 0);
                        $grandTotal += $totalCost;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ optional($tx->product)->name }}</strong>
                            <br><small class="text-muted">SKU: {{ optional($tx->product)->sku }}</small>
                        </td>
                        <td class="text-center">{{ optional($tx->unit)->name }}</td>
                        <td class="text-center">{{ number_format($tx->quantity, 3) }}</td>
                        <td class="text-center">${{ number_format($tx->cost_price, 3) }}</td>
                        <td class="text-center">${{ number_format($totalCost, 3) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="table-light">
                    <td colspan="5" class="text-end fw-bold">ទឹកប្រាក់សរុប:</td>
                    <td class="text-center fw-bold">${{ number_format($grandTotal, 3) }}</td>
                </tr>
            </tfoot>
        </table>
        <div class="row mt-5 pt-4">
            <div class="col-6 text-center">
                <p class="fw-bold mb-5">អ្នករៀបចំ</p>
                <p class="mb-0">........................................</p>
            </div>
            <div class="col-6 text-center">
                <p class="fw-bold mb-5">អ្នកត្រួតពិនិត្យ</p>
                <p class="mb-0">........................................</p>
            </div>
        </div>
    </div>
</body>

</html>
