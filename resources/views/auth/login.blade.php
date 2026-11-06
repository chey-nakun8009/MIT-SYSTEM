<x-guest-layout>
    <!-- Language Switcher -->
    <div class="d-flex justify-content-end mb-4">
        @php
            $currentLanguage = app()->getLocale();

            $languages = [
                'en' => 'English',
                'km' => 'ខ្មែរ',
                // 'zh_CN' => '简体中文',
            ];
        @endphp

        <div class="dropdown">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle rounded-0" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-translate me-1"></i>
                {{ $languages[$currentLanguage] ?? 'English' }}
            </button>

            <ul class="dropdown-menu dropdown-menu-end rounded-0">
                @foreach ($languages as $code => $name)
                    <li>
                        <form method="POST" action="{{ route('language.update') }}">
                            @csrf

                            <input type="hidden" name="language" value="{{ $code }}">

                            <button type="submit"
                                class="dropdown-item {{ $currentLanguage === $code ? 'active' : '' }}">
                                {{ $name }}

                                @if ($currentLanguage === $code)
                                    <i class="bi bi-check2 ms-2"></i>
                                @endif
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1">
            {{ __('messages.welcome') }}
        </h2>

        <p class="text-muted small">
            {{ __('messages.login_description') }}
        </p>
    </div>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <x-input name="email" label="{{ __('messages.email') }}" type="email"
                placeholder="user@example.com" />
        </div>
        <div class="mb-3">
            <x-input name="password" label="{{ __('messages.password') }}" type="password" placeholder="••••••••" />
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                <label class="form-check-label small text-secondary" for="remember_me">
                    {{ __('messages.remember_me') }}
                </label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold shadow-sm mb-3 rounded-0">
            {{ __('messages.login') }}
        </button>
        @if (Route::has('register'))
            <p class="text-center small text-muted mb-0">
                {{ __('messages.no_account') }}

                <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-semibold">
                    {{ __('messages.register') }}
                </a>
            </p>
        @endif
    </form>
</x-guest-layout>
