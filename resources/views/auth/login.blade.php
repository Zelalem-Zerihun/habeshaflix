<x-layouts.netflix title="Sign In - HabeshaFlix">
    <header class="nf-header nf-header-landing">
        <a class="nf-logo" href="{{ route('landing') }}">HABESHAFLIX</a>
    </header>

    <main class="nf-signin">
        <form class="nf-form" method="POST" action="{{ route('login') }}">
            @csrf
            <h1>Sign In</h1>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <div class="nf-form-group">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Email address">
                <x-input-error :messages="$errors->get('email')" class="nf-error" />
            </div>

            <div class="nf-form-group">
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password">
                <x-input-error :messages="$errors->get('password')" class="nf-error" />
            </div>

            <button type="submit" class="nf-btn nf-btn-danger" style="width: 100%; margin-top: 1rem;">
                Sign In
            </button>

            <div class="nf-form-help">
                <label class="nf-checkbox-wrapper">
                    <input type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </div>

            <p class="nf-form-footer">
                New to HabeshaFlix? <a href="{{ route('register') }}">Sign up now</a>.
            </p>
        </form>
    </main>

    <style>
        .nf-form-group {
            margin-bottom: 1rem;
        }
        .nf-error {
            color: #e87c03;
            font-size: 0.8rem;
            margin-top: 0.4rem;
            list-style: none;
            padding: 0;
        }
        .nf-form-help {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.5rem;
            color: #b3b3b3;
            font-size: 0.8rem;
        }
        .nf-checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            cursor: pointer;
        }
        .nf-form-footer {
            margin-top: 3rem;
            color: #737373;
            font-size: 1rem;
        }
        .nf-form-footer a {
            color: #fff;
        }
        .nf-form-footer a:hover {
            text-decoration: underline;
        }
    </style>
</x-layouts.netflix>
