<nav class="navbar navbar-expand navbar-dark pos-navbar px-3 py-2">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center gap-3 mb-0" href="#">
            <div class="pos-brand-icon">
                @if (setting('system_logo'))
                    <img src="{{ asset('storage/uploads/settings/' . setting('system_logo')) }}"
                        alt="{{ setting('system_name', 'Mkot Glass') }}"
                        style="width: {{ setting('logo_width', 'auto') }};
               height: {{ setting('logo_height', '40px') }};
               border-radius: {{ setting('logo_border_radius', '0') }};">
                @else
                    <img src="{{ asset('photos/school_logo.jpg') }}" alt="Logo" height="40">
                @endif
            </div>

            <div class="d-flex flex-column">
                <span class="fw-bold text-white">
                    {{ setting('system_name', 'សាលាពហុវិជ្ជាមុន្នីជោតិ') }}
                </span>
                <small class="text-white-50">POINT OF SALE SYSTEM</small>
            </div>
        </a>
        <div class="ms-auto d-flex align-items-center gap-2">
            <div class="pos-clock-box d-flex align-items-center gap-2">
                <i class="bi bi-clock-history"></i>
                <span id="pos-clock">--:--:--</span>
            </div>
            <a href="{{ route('dashboard') }}" class="pos-nav-link d-flex align-items-center gap-2">
                <i class="bi bi-speedometer2"></i>
                <span>ផ្ទាំងគ្រប់គ្រង</span>
            </a>
            <div class="pos-user-info d-flex align-items-center gap-2">
                <div class="pos-user-icon">
                    <i class="bi bi-person-fill"></i>
                </div>

                <div class="d-flex flex-column">
                    <span class="text-white fw-semibold">
                        {{ auth()->user()->first_name }}
                        {{ auth()->user()->last_name }}
                    </span>
                    <small class="text-white-50">Cashier</small>
                </div>
            </div>

        </div>
    </div>
</nav>
