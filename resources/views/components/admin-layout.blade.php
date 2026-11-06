<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

@include('admin.includes.head')

<body data-page="dashboard" class="admin-layout">
    <a href="#main-content" class="skip-link">Skip to main content</a>
    @include('admin.includes.loading-page')
    <div class="admin-app">
        <div class="admin-wrapper" id="admin-wrapper">
            @include('admin.includes.nav-header')
            @include('admin.includes.aside')
            <div class="sidebar-backdrop" aria-hidden="true"></div>
            <main id="main-content" class="admin-main">
                <div class="container-fluid">
                    {{ $slot }}
                </div>
            </main>
            @include('admin.includes.footer')
        </div>
    </div>
    @include('components.toast')
    @include('admin.includes.new-modal')
</body>

</html>
