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
