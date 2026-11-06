<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'School Management System') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --body-bg: #f8fafc;
            --text-color: #1e293b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Noto Sans Khmer', sans-serif;
            color: var(--text-color);
            background: var(--body-bg);
        }

        .auth-wrapper {
            min-height: 100vh;
        }

        .auth-hero {
            position: relative;
            min-height: 100vh;
            background:
                linear-gradient(135deg, rgba(15, 23, 42, .85), rgba(37, 99, 235, .65)),
                url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1600&auto=format&fit=crop') center / cover no-repeat;
        }

        .auth-hero-content {
            max-width: 550px;
        }

        .auth-form-wrapper {
            width: 100%;
            max-width: 440px;
        }

        .auth-logo {
            width: 65px;
            height: 65px;
            object-fit: contain;
        }

        @media (max-width: 991.98px) {
            .auth-wrapper {
                background: #fff;
            }

            .auth-form-section {
                min-height: 100vh;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid p-0">
        <div class="row g-0 auth-wrapper">
            <div
                class="col-lg-6 col-xl-7 d-none d-lg-flex flex-column justify-content-between p-5 text-white auth-hero">

                <div class="d-flex justify-content-center">
                    <a href="/" class="text-decoration-none text-white d-inline-flex align-items-center gap-2">
                        <x-application-logo class="auth-logo" />
                    </a>
                </div>

                <div class="auth-hero-content my-auto mx-auto text-center">
                    <h2 class="fw-bold mb-4">
                        សូមស្វាគមន៍លោកអ្នកមកកាន់ប្រព័ន្ធគ្រប់គ្រងសាលារៀន
                    </h2>

                    <p class="fs-5 text-white-50 mb-0">
                        {{ config('app.name', 'School Management System') }}
                    </p>
                </div>

                <div class="small text-white-50">
                    &copy; {{ date('Y') }}
                    {{ config('app.name', 'School Management System') }}.
                    All rights reserved.
                </div>

            </div>
            <div
                class="col-lg-6 col-xl-5 d-flex align-items-center justify-content-center bg-white p-4 p-sm-5 auth-form-section">
                <div class="auth-form-wrapper">
                    <div class="text-center mb-4 d-lg-none">

                        <a href="/" class="text-decoration-none">
                            <x-application-logo class="auth-logo mb-3" />
                        </a>

                        <h4 class="fw-bold text-dark mb-1">
                            {{ config('app.name', 'School Management System') }}
                        </h4>
                        <p class="text-muted small">
                            ប្រព័ន្ធគ្រប់គ្រងសាលារៀន
                        </p>

                    </div>

                    {{ $slot }}

                </div>

            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
