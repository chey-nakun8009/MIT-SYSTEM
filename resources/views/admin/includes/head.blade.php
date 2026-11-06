<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta name="description" content="MTI SYSTEM">
    <meta name="keywords" content="MTI SYSTEM">
    <meta name="author" content="MTI SYSTEM">
    <meta property="og:title" content="MTI SYSTEM">
    <meta property="og:description" content="MTI SYSTEM">
    <meta property="og:type" content="website">

    <title>{{ setting('system_name', 'MTI SYSTEM') }}</title>
    <meta property="og:image"
        content="{{ $ogImage ?? (setting('system_logo') ? asset('uploads/settings/' . setting('system_logo')) : asset('photos/default_logo.png')) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta name="twitter:image"
        content="{{ $ogImage ?? (setting('system_logo') ? asset('uploads/settings/' . setting('system_logo')) : asset('photos/default_logo.png')) }}">
    @if (setting('favicon'))
        <link rel="icon" href="{{ asset('uploads/settings/' . setting('favicon')) }}" type="image/x-icon">
    @else
        <link rel="icon" href="{{ asset('photos/school_logo.jpg') }}" type="image/x-icon">
    @endif
    <meta name="theme-color" content="#2563eb">
    <link rel="manifest" href="{{ asset('admin/manifest.json') }}">

    @vite(['resources/css/admin.css', 'resources/js/admin.js'])

    <link rel="stylesheet" href="{{ asset('admin/styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/system_setting.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * {
            font-family: "Noto Sans Khmer", sans-serif !important;
        }
    </style>
    <style>
        :root {
            /* start logo and brand  */
            --logo-width: {{ setting('logo_width', '40px') }};
            --logo-height: {{ setting('logo_height', '40px') }};
            --logo-radius: {{ setting('logo_border_radius', '0.375rem') }};
            --brand-color: {{ setting('brand_text_color', '#212529') }};
            --brand-font-size: {{ setting('brand_font_size', '1.25rem') }};
            /* end logo and brand  */

            /* start them color and langues */

            --primary-color: {{ setting('primary_color', '#008585') }};
            --secondary-color: {{ setting('secondary_color', '#6c757d') }};
            --english-font: '{{ setting('english_font', 'Poppins') }}', sans-serif;
            --khmer-font: '{{ setting('khmer_font', 'Noto Sans Khmer') }}', sans-serif;

            /* start aside */
            --sidebar-active-bg: {{ setting('sidebar_active_bg', '#b1401b') }};
            --sidebar-active-color: {{ setting('sidebar_active_color', '#ffffff') }};
            --sidebar-hover-bg: {{ setting('sidebar_hover_bg', '#f8f9fa') }};
            --sidebar-font-size: {{ setting('sidebar_font_size', '0.95rem') }};
            --sidebar-section-color: {{ setting('sidebar_section_color', '#6c757d') }};
            /* end aside  */

            /* start toast */
            --toast-bg: {{ setting('toast_bg_color', '#198754') }};
            --toast-color: {{ setting('toast_text_color', '#ffffff') }};
            --toast-error-bg: {{ setting('toast_error_bg_color', '#dc3545') }};
            --toast-error-color: {{ setting('toast_error_text_color', '#ffffff') }};
            --toast-radius: {{ setting('toast_border_radius', '0px') }};
            /* end toast  */

            /* start table */
            --table-th-bg: {{ setting('table_header_color', '#008585') }};
            --table-th-color: {{ setting('table_header_text_color', '#ffffff') }};
            --table-th-align: {{ setting('table_header_alignment', 'center') }};
            --table-td-align: {{ setting('table_body_alignment', 'left') }};
            --table-th-padding: {{ setting('table_th_padding', '12px') }};
            --table-td-padding: {{ setting('table_td_padding', '10px') }};
            --table-th-font-size: {{ setting('table_th_font_size', '12px') }};
            --table-td-font-size: {{ setting('table_td_font_size', '10px') }};
            /* end table  */

            --btn-custom-bg: {{ setting('button_bg_color', '#008585') }};
            --btn-custom-color: {{ setting('button_text_color', '#ffffff') }};
            --btn-custom-hover-bg: {{ setting('button_hover_bg', '#006666') }};
            --btn-sec-bg: {{ setting('btn_secondary_bg', '#6c757d') }};
            --btn-sec-color: {{ setting('btn_secondary_color', '#ffffff') }};
            --btn-sec-hover-bg: {{ setting('btn_secondary_hover_bg', '#5c636a') }};
        }
    </style>
</head>
