<x-guest-layout>
    <div class="d-flex justify-content-end mb-4"> @php
        $currentLanguage = app()->getLocale();
        $languages = ['en' => 'English', 'km' => 'ខ្មែរ'];
    @endphp <div class="dropdown"> <button
                class="btn btn-outline-secondary btn-sm dropdown-toggle rounded-0" type="button" data-bs-toggle="dropdown"
                aria-expanded="false"> <i class="bi bi-translate me-1"></i>
                {{ $languages[$currentLanguage] ?? 'English' }} </button>
            <ul class="dropdown-menu dropdown-menu-end rounded-0">
                @foreach ($languages as $code => $name)
                    <li>
                        <form method="POST" action="{{ route('language.update') }}"> @csrf <input type="hidden"
                                name="language" value="{{ $code }}"> <button type="submit"
                                class="dropdown-item {{ $currentLanguage === $code ? 'active' : '' }}">
                                {{ $name }} @if ($currentLanguage === $code)
                                    <i class="bi bi-check2 ms-2"></i>
                                @endif </button> </form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1">
            {{ __('messages.create_account') }}
        </h2>

        <p class="text-muted small">
            {{ __('messages.register_description') }}
        </p>
    </div>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <x-input name="first_name" label="{{ __('messages.first_name') }} *" type="text"
                    placeholder="{{ __('messages.first_name_placeholder') }}" :value="old('first_name')" autofocus />
            </div>

            <div class="col-md-6 mb-3">
                <x-input name="last_name" label="{{ __('messages.last_name') }}" type="text"
                    placeholder="{{ __('messages.last_name_placeholder') }}" :value="old('last_name')" />
            </div>
        </div>
        <div class="mb-3">
            <x-input name="email" label="{{ __('messages.email_address') }} *" type="email"
                placeholder="{{ __('messages.email_placeholder') }}" :value="old('email')" />
        </div>
        <div class="mb-3">
            <x-input name="phone" label="{{ __('messages.phone_number') }}" type="text"
                placeholder="{{ __('messages.phone_placeholder') }}" :value="old('phone')" />
        </div>
        <div class="mb-3">
            <x-input name="password" label="{{ __('messages.password') }} *" type="password"
                placeholder="{{ __('messages.password_placeholder') }}" />
        </div>
        <div class="mb-3">
            <x-input name="password_confirmation" label="{{ __('messages.confirm_password') }} *" type="password"
                placeholder="{{ __('messages.confirm_password_placeholder') }}" />
        </div>
        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" id="terms" name="terms" value="1"
                {{ old('terms') ? 'checked' : '' }}>
            <label class="form-check-label small text-secondary" for="terms">
                {{ __('messages.agree_terms') }}

                <a href="#" class="text-primary text-decoration-none">
                    {{ __('messages.terms_of_service') }}
                </a>
                {{ __('messages.and') }}
                <a href="#" class="text-primary text-decoration-none">
                    {{ __('messages.privacy_policy') }}
                </a>
            </label>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-2 shadow-sm mb-3">
            {{ __('messages.create_account') }}
        </button>
        <p class="text-center small text-muted mb-0">
            {{ __('messages.already_have_account') }}
            <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-semibold">
                {{ __('messages.sign_in') }}
            </a>
        </p>
    </form>
</x-guest-layout>
