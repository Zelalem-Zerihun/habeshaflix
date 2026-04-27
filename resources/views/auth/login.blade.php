<x-layouts.netflix title="Sign In - HabeshaFlix">
    <header class="nf-header nf-header-landing">
        <a class="nf-logo" href="{{ route('landing') }}">HABESHAFLIX</a>
    </header>

    <main class="nf-signin">
        <form class="nf-form" method="POST" action="{{ route('login') }}">
            @csrf
            <h1>Sign In</h1>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #b3b3b3;">Email</label>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                    style="width: 100%; padding: 0.75rem; background: #333; border: none; border-radius: 4px; color: white;">
                <x-input-error :messages="$errors->get('email')" style="color: #e50914; font-size: 0.8rem; margin-top: 0.25rem;" />
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #b3b3b3;">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    style="width: 100%; padding: 0.75rem; background: #333; border: none; border-radius: 4px; color: white;">
                <x-input-error :messages="$errors->get('password')" style="color: #e50914; font-size: 0.8rem; margin-top: 0.25rem;" />
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; color: #b3b3b3; font-size: 0.85rem;">
                    <input type="checkbox" name="remember" style="margin-right: 0.5rem;">
                    Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="color: #b3b3b3; font-size: 0.85rem; text-decoration: none;">Forgot password?</a>
                @endif
            </div>

            <button type="submit" class="nf-btn nf-btn-danger" style="width: 100%; padding: 0.8rem; font-size: 1rem;">
                Sign In
            </button>

            <p style="margin-top: 2rem; color: #737373;">
                New to HabeshaFlix? <a href="{{ route('register') }}" style="color: #fff; text-decoration: none;">Sign up now</a>.
            </p>
        </form>
    </main>
</x-layouts.netflix>
