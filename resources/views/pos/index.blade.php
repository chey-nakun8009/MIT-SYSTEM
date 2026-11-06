<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Point of Sale (POS)</title>
    @vite(['resources/css/pos/style.css', 'resources/js/pos/store_order.js', 'resources/js/pos/cart_action.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @if (setting('favicon'))
        <link rel="icon" href="{{ asset('uploads/settings/' . setting('favicon')) }}" type="image/x-icon">
    @else
        <link rel="icon" href="{{ asset('photos/school_logo.jpg') }}" type="image/x-icon">
    @endif
    <style>
        :root {
            --primary-accent: #BA7D02;
            --primary-accent-hover: #966402;
            --bg-light: #f8f9fa;
            --primary-color: {{ setting('primary_color', '#008585') }};
        }
        * {
            font-family: "Noto Sans Khmer", sans-serif !important;
        }
        body {
            background-color: var(--bg-light);
            height: 100vh;
            overflow: hidden;
        }
        .pos-container {
            height: calc(100vh - 56px);
        }
        .product-card {
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            border: 1px solid #e3e6f0;
        }
        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-color: var(--primary-accent);
        }
        .btn-accent {
            background-color: var(--primary-accent);
            color: #fff;
            border: none;
        }
        .btn-accent:hover {
            background-color: var(--primary-accent-hover);
            color: #fff;
        }
        .btn-outline-accent {
            color: var(--primary-accent);
            border-color: var(--primary-accent);
        }
        .btn-outline-accent:hover,
        .btn-check:checked+.btn-outline-accent {
            background-color: var(--primary-accent);
            border-color: var(--primary-accent);
            color: #fff;
        }
        .cart-table-wrapper {
            max-height: calc(100vh - 380px);
            overflow-y: auto;
        }
        .qty-btn {
            width: 28px;
            height: 28px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .main-bg {
            background-color: #BA7D02 !important;
        }
    </style>
</head>
<body>
    @include('pos.partials._nav')
    <div class="container-fluid pos-container">
        @include('pos.partials._success_order_modal')
        <div class="row h-100">
            <div class="col-lg-8 col-xl-8 d-flex flex-column h-100 p-3 border-end bg-white">
                <div class="row g-2 mb-3">
                    @include('pos.partials._search')
                    @include('pos.partials._categories')
                </div>
                <div class="flex-grow-1 overflow-auto p-2">
                    @include('pos.partials._products')
                </div>
            </div>

            @include('pos.partials._cart')
        </div>
    </div>
    @include('pos.partials._modal_payment')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
