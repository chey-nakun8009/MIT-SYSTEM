<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <title>របាយការណ៍បញ្ជាទិញ (Order Report)</title>
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
            font-size: 13px;
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
            <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-sm rounded-0">
                <i class="bi bi-arrow-left"></i> ត្រឡប់ក្រោយ
            </a>
            <button onclick="window.print()" class="btn btn-primary btn-sm rounded-0">
                <i class="bi bi-printer"></i> បោះពុម្ព/ទាញយក PDF
            </button>
        </div>
        <div class="mb-4 pb-3" style="border-bottom: 2px solid #BA7D02;">
            <div class="d-flex align-items-center">
                <div style="width: 100px; flex-shrink: 0;" class="text-center">
                    @if (setting('system_logo'))
                        <img src="{{ asset('uploads/settings/' . setting('system_logo')) }}" alt="System Logo"
                            style="width: 85px; height: 85px; object-fit: contain;">
                    @endif
                </div>
                <div class="flex-grow-1 text-center">
                    <h3 class="fw-bold mb-1">
                        {{ optional(auth()->user()->campus)->name ?? 'Mkot System' }}
                    </h3>
                    <h5 class="fw-bold mb-2" style="color: #BA7D02;">
                        របាយការណ៍ប្រតិបត្តិការលក់ (POS Order Report)
                    </h5>
                    <p class="small mb-0">
                        កាលបរិច្ឆេទបោះពុម្ព: {{ now()->format('d-m-Y H:i') }}
                    </p>
                </div>
                <div style="width: 100px; flex-shrink: 0;"></div>
            </div>
        </div>
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th class="text-center bg-dark text-white" style="width: 5%;">ល.រ</th>
                    <th class="bg-dark text-white">លេខវិក្កយបត្រ</th>
                    <th class="bg-dark text-white">អតិថិជន</th>
                    <th class="text-center bg-dark text-white">ចំនួនមុខទំនិញ</th>
                    <th class="text-center bg-dark text-white" style="width: 140px !important;">កាលបរិច្ឆេទ</th>
                    <th class="text-center bg-dark text-white" style="width: 120px !important;">ទឹកប្រាក់</th>
                </tr>
            </thead>
            <tbody>
                @php $totalRevenue = 0; @endphp
                @foreach ($orders as $index => $order)
                    @php $totalRevenue += $order->grand_total; @endphp
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><strong>{{ $order->order_number }}</strong></td>
                        <td>{{ $order->customer_phone ?? 'អតិថិជនទូទៅ (Walk-in)' }}</td>
                        <td class="text-center">{{ $order->items->sum('quantity') }} items</td>
                        <td class="text-center">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                        <td class="text-center fw-bold text-success">
                            ${{ number_format($order->grand_total, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="table-light">
                    <td colspan="5" class="text-end fw-bold">ទឹកប្រាក់សរុប (Total Revenue):</td>
                    <td class="fw-bold text-center text-success">${{ number_format($totalRevenue, 2) }}</td>
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
