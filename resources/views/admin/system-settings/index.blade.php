<x-admin-layout>
    <div class="container-fluid px-2">
        <div class="card shadow-sm rounded-0">
            <div class="bg-primary card-header py-3 rounded-0">
                <h6 class="mb-0 form-label text-white">
                    System Settings
                </h6>
            </div>
            <div class="card-body">
                @include('admin.system-settings.form')
            </div>
        </div>
    </div>
</x-admin-layout>
