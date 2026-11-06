<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $order->order_number }}</title>
    <link rel="icon" type="image/png" href="{{ asset('photos/school_logo.jpg') }}">
    <style>
        @page {
            size: A5 portrait;
            margin: 8mm;
        }

        body {
            font-family: 'Khmer OS Battambang', 'Noto Sans Khmer', Arial, sans-serif;
            font-size: 10px;
            color: #111;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }

        .invoice-box {
            max-width: 148mm;
            margin: auto;
            padding: 2mm;
            background: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1.5px solid #333;
            padding-bottom: 6px;
        }

        .header h2 {
            margin: 0 0 2px 0;
            font-size: 14px;
        }

        .header p {
            margin: 1px 0;
            font-size: 9px;
            color: #555;
        }

        .info-table,
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .info-table td {
            padding: 2px 0;
            vertical-align: top;
            font-size: 10px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #ccc;
            padding: 4px 6px;
            text-align: left;
            font-size: 10px;
        }

        .items-table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totals-section {
            width: 55%;
            float: right;
            margin-bottom: 15px;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 3px 4px;
            font-size: 10px;
        }

        .footer {
            clear: both;
            text-align: center;
            margin-top: 20px;
            font-size: 9px;
            border-top: 1px dashed #ccc;
            padding-top: 6px;
            color: #555;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="invoice-box">
        <div class="no-print" style="margin-bottom: 10px; text-align: right;">
            <button onclick="window.print()"
                style="padding: 5px 10px; background: #000; color: #fff; border: none; border-radius: 3px; cursor: pointer; font-size: 10px;">🖨️
                Print A5</button>
        </div>
        <div class="header">
            <h2>Mony Chort Tech Institute - POS System</h2>
            <p>Reference No: {{ $referenceNo }}</p>
        </div>
        <table class="info-table">
            <tr>
                <td>
                    <strong>អតិថិជន</strong> {{ $order->customer_email ?? 'Walk-in' }}<br>
                    <strong>ទូរស័ព្ទ</strong> {{ $order->customer_phone ?? 'N/A' }}
                </td>
                <td class="text-end">
                    <strong>វិក្កយបត្រ</strong> {{ $order->order_number }}<br>
                    <strong>កាលបរិច្ឆេទ</strong> {{ $order->created_at->format('d/m/Y H:i') }}<br>
                    <strong>Cashier</strong> {{ $order->user->name ?? 'Staff' }}
                </td>
            </tr>
        </table>
        <table class="items-table">
            <thead>
                <tr>
                    <th class="text-center" style="width: 25px;">ល.រ</th>
                    <th>បរិយាយមុខទំនិញ</th>
                    <th class="text-center" style="width: 50px;">ចំនួន</th>
                    <th class="text-end" style="width: 65px;">តម្លៃឯកតា</th>
                    <th class="text-end" style="width: 65px;">សរុប</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->product_name }}</td>
                        <td class="text-center"> {{ number_format($item->quantity, 0) }}</td>
                        <td class="text-end">${{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-end">${{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td><strong>សរុប</strong></td>
                    <td class="text-end">${{ number_format($order->subtotal, 2) }}</td>
                </tr>
                @if ($order->discount_amount > 0)
                    <tr>
                        <td><strong>បញ្ចុះតម្លៃ</strong></td>
                        <td class="text-end">-${{ number_format($order->discount_amount, 2) }}</td>
                    </tr>
                @endif
                <tr style="border-top: 1.2px solid #000; border-bottom: 2px solid #000; font-size: 11px;">
                    <td><strong>សរុបទឹកប្រាក់:</strong></td>
                    <td class="text-end"><strong>${{ number_format($order->grand_total, 2) }}</strong></td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <p>អរគុណសម្រាប់ការអញ្ជើញមកទិញទំនិញនៅសាលារបស់យើងខ្ញុំ! / Thank you!</p>
            <p>Software developed by Mony Techs</p>
        </div>
    </div>

</body>

</html>
