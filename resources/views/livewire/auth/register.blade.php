<x-layouts::auth max-width="800px">
    <div class="auth-logo">
        <div class="auth-logo-icon">
            <x-app-logo-icon class="w-full h-full" style="fill: #6366f1;" />
        </div>
        <h1 class="auth-title">{{ __('Create Account') }}</h1>
        <p class="auth-subtitle">{{ __('Sign up to get started') }}</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="auth-alert success">
            {{ session('status') }}
        </div>
    @endif

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="auth-alert error">
            <ul style="margin: 0; padding-left: 1.25rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}" class="auth-form">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-x-6">
            <!-- Name -->
            <div class="auth-form-group">
                <label for="name">{{ __('Name') }}</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="{{ __('Full name') }}"
                    class="auth-input"
                />
            </div>

            <!-- NIM -->
            <div class="auth-form-group">
                <label for="nim">{{ __('NIM') }}</label>
                <input
                    id="nim"
                    type="text"
                    name="nim"
                    value="{{ old('nim') }}"
                    required
                    autocomplete="off"
                    placeholder="{{ __('12345678') }}"
                    class="auth-input"
                />
            </div>

            <!-- Tahun Lulus -->
            <div class="auth-form-group">
                <label for="tahun_lulus">{{ __('Year of Graduation') }}</label>
                <input
                    id="tahun_lulus"
                    type="number"
                    name="tahun_lulus"
                    value="{{ old('tahun_lulus') }}"
                    min="2000"
                    max="{{ date('Y') }}"
                    required
                    autocomplete="off"
                    placeholder="{{ __('2024') }}"
                    class="auth-input"
                />
            </div>

            <!-- No HP -->
            <div class="auth-form-group">
                <label for="no_hp">{{ __('Phone Number') }}</label>
                <input
                    id="no_hp"
                    type="tel"
                    name="no_hp"
                    value="{{ old('no_hp') }}"
                    autocomplete="tel"
                    placeholder="{{ __('08123456789') }}"
                    class="auth-input"
                />
            </div>

            <!-- Email Address -->
            <div class="auth-form-group">
                <label for="email">{{ __('Email address') }}</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    placeholder="email@example.com"
                    class="auth-input"
                />
            </div>

            <!-- Password -->
            <div class="auth-form-group">
                <label for="password">{{ __('Password') }}</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="{{ __('Password') }}"
                    class="auth-input"
                />
            </div>

            <!-- Confirm Password -->
            <div class="auth-form-group">
                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="{{ __('Confirm password') }}"
                    class="auth-input"
                />
            </div>
            
             <!-- Address (Full Width at Bottom) -->
             <div class="auth-form-group md:col-span-2">
                 <label for="alamat">{{ __('Address') }}</label>
                 <textarea
                     id="alamat"
                     name="alamat"
                     autocomplete="street-address"
                     placeholder="{{ __('Complete address') }}"
                     class="auth-input"
                     rows="3"
                     style="min-height: 80px; resize: vertical;"
                 >{{ old('alamat') }}</textarea>
             </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="auth-button" data-test="register-user-button">
            {{ __('Create Account') }}
        </button>
    </form>

    <div class="auth-footer">
        <span>{{ __('Already have an account?') }}</span>
        <a href="{{ route('login') }}" class="auth-link" wire:navigate>{{ __('Log in') }}</a>
    </div>
</x-layouts::auth>
