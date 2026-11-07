 <header class="admin-header">
     <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
         <div class="container-fluid">
             <a class="navbar-brand d-flex align-items-center" href="./index.html">
                 @if (setting('system_logo'))
                     <img src="{{ asset('storage/uploads/settings/' . setting('system_logo')) }}"
                         alt="{{ setting('system_name', 'logo') }}" height="40"
                         class="d-inline-block align-text-top me-2"
                         style="width: {{ setting('logo_width', 'auto') }}; height: {{ setting('logo_height', '40px') }}; border-radius: {{ setting('logo_border_radius', '0') }};">
                 @else
                     <img src="{{ asset('photos/login_logo.png') }}" alt="Logo" height="40"
                         class="d-inline-block align-text-top me-2">
                 @endif
                 <span class="h4 mb-0 fw-bold"
                     style="color: {{ setting('brand_text_color', 'inherit') }}; font-size: {{ setting('brand_font_size', '') }};">
                     {{ setting('system_name', 'MTI SYSTEM') }}
                 </span>
             </a>
             <button class="hamburger-menu" type="button" data-sidebar-toggle aria-label="Toggle sidebar">
                 <i class="bi bi-list"></i>
             </button>
             <div class="navbar-nav flex-row">
                 <a href="{{ route('pos.index') }}" class="btn btn-outline-secondary me-2 d-none d-lg-inline-block"
                     title="ទៅកាន់កន្លែងលក់">
                     <i class="bi bi-cart-check"></i>
                 </a>
                 <div x-data="themeSwitch">
                     <button class="btn btn-outline-secondary me-2" type="button" @click="toggle()"
                         data-bs-toggle="tooltip" data-bs-placement="bottom" title="Toggle theme">
                         <i class="bi bi-sun-fill" x-show="currentTheme === 'light'"></i>
                         <i class="bi bi-moon-fill" x-show="currentTheme === 'dark'"></i>
                     </button>
                 </div>
                 <button class="btn btn-outline-secondary me-2 d-none d-lg-inline-block" type="button"
                     data-fullscreen-toggle data-bs-toggle="tooltip" data-bs-placement="bottom"
                     title="Toggle fullscreen">
                     <i class="bi bi-arrows-fullscreen icon-hover"></i>
                 </button>
                 <div class="dropdown me-2">
                     <button class="btn btn-outline-secondary d-flex align-items-center" type="button"
                         data-bs-toggle="dropdown" aria-expanded="false">

                         @if (app()->getLocale() === 'km')
                             <span class="me-1">🇰🇭</span>
                             <span class="d-none d-md-inline">ខ្មែរ</span>
                         @else
                             <span class="me-1">🇺🇸</span>
                             <span class="d-none d-md-inline">English</span>
                         @endif
                         <i class="bi bi-chevron-down ms-1"></i>
                     </button>

                     <ul class="dropdown-menu dropdown-menu-end">

                         <li>
                             <h6 class="dropdown-header">
                                 Language
                             </h6>
                         </li>

                         <li>
                             <form action="{{ route('language.update') }}" method="POST">
                                 @csrf
                                 <input type="hidden" name="language" value="en">
                                 <button type="submit"
                                     class="dropdown-item d-flex align-items-center {{ app()->getLocale() === 'en' ? 'active' : '' }}">
                                     <span class="me-2">🇺🇸</span>
                                     <span>English</span>

                                     @if (app()->getLocale() === 'en')
                                         <i class="bi bi-check2 ms-auto"></i>
                                     @endif
                                 </button>
                             </form>
                         </li>

                         <li>
                             <form action="{{ route('language.update') }}" method="POST">
                                 @csrf
                                 <input type="hidden" name="language" value="km">

                                 <button type="submit"
                                     class="dropdown-item d-flex align-items-center {{ app()->getLocale() === 'km' ? 'active' : '' }}">
                                     <span class="me-2">🇰🇭</span>
                                     <span>ខ្មែរ</span>

                                     @if (app()->getLocale() === 'km')
                                         <i class="bi bi-check2 ms-auto"></i>
                                     @endif
                                 </button>
                             </form>
                         </li>
                     </ul>
                 </div>
                 <div class="dropdown">
                     <button class="btn btn-outline-secondary d-flex align-items-center" type="button"
                         data-bs-toggle="dropdown" aria-expanded="false">
                         <img src="{{ auth()->user()->showUserProfile() }}" alt="User Avatar" width="24"
                             height="24" class="rounded-circle me-2">
                         <span class="d-none d-md-inline text-start">
                             <span class="d-block fw-bold">
                                 {{ auth()->user()->first_name }}
                                 {{ auth()->user()->last_name }}({{ auth()->user()->campus?->name ?? 'មិនស្ថានក្នុងសាខា' }})
                             </span>
                             <small class="text-muted">
                                 {{ auth()->user()->email }}
                             </small>
                         </span>
                         <i class="bi bi-chevron-down ms-2"></i>
                     </button>
                     <ul class="dropdown-menu dropdown-menu-end">
                         <li>
                             <a class="dropdown-item" href="{{ route('system-settings.index') }}">
                                 <i class="bi bi-gear me-2"></i>Settings
                             </a>
                         </li>
                         <li>
                             <hr class="dropdown-divider">
                         </li>
                         <li>
                             <form method="POST" action="{{ route('logout') }}">
                                 @csrf
                                 <button type="submit" class="dropdown-item text-danger">
                                     <i class="bi bi-box-arrow-right me-2"></i>Logout
                                 </button>
                             </form>
                         </li>
                     </ul>
                 </div>
             </div>
         </div>
     </nav>
 </header>
