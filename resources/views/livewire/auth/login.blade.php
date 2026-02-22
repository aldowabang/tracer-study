<x-layouts::auth>
    <div class="auth-logo">
        <div class="auth-logo-icon">
            <x-app-logo-icon class="w-full h-full" style="fill: #6366f1;" />
        </div>
        <h1 class="auth-title">{{ __('Welcome Back') }}</h1>
        <p class="auth-subtitle">{{ __('Sign in to access your account') }}</p>
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

    <form method="POST" action="{{ route('login.store') }}" class="auth-form">
        @csrf

        <!-- Email Address -->
        <div class="auth-form-group">
            <label for="email">{{ __('Email address') }}</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
                class="auth-input"
            />
        </div>

        <!-- Password -->
        <div class="auth-form-group">
            <label for="password">{{ __('Password') }}</label>
            <div class="auth-input-wrapper">
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="{{ __('Enter your password') }}"
                    class="auth-input"
                />
                <button type="button" onclick="const input = document.getElementById('password'); const iconEye = document.getElementById('icon-eye'); const iconEyeSlash = document.getElementById('icon-eye-slash'); if(input.type === 'password') { input.type = 'text'; iconEye.style.display = 'none'; iconEyeSlash.style.display = 'block'; } else { input.type = 'password'; iconEye.style.display = 'block'; iconEyeSlash.style.display = 'none'; }" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--auth-text-muted); padding: 0; outline: none;">
                    <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 1.25rem; height: 1.25rem;">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg id="icon-eye-slash" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 1.25rem; height: 1.25rem; display: none;">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Forgot Password Link -->
        @if (Route::has('password.request'))
            <div class="auth-forgot-password">
                <a href="{{ route('password.request') }}" class="auth-link">
                    {{ __('Forgot your password?') }}
                </a>
            </div>
        @endif

        <!-- Remember Me -->
        <div class="auth-checkbox">
            <input
                type="checkbox"
                id="remember"
                name="remember"
                {{ old('remember') ? 'checked' : '' }}
            />
            <label for="remember">{{ __('Remember me') }}</label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="auth-button" data-test="login-button">
            {{ __('Sign In') }}
        </button>
    </form>

    <!-- Register Link -->
    @if (Route::has('register'))
        <div class="auth-footer">
            <span>{{ __("Don't have an account?") }}</span>
            <a href="{{ route('register') }}" class="auth-link">{{ __('Sign up') }}</a>
        </div>
    @endif
</x-layouts::auth>
