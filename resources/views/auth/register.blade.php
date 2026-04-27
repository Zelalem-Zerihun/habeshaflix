<x-layouts.netflix title="Sign Up - HabeshaFlix">
    <header class="nf-header nf-header-landing">
        <a class="nf-logo" href="{{ route('landing') }}">HABESHAFLIX</a>
    </header>

    <main class="nf-signin">
        <form class="nf-form" method="POST" action="{{ route('register') }}">
            @csrf
            <h1>Sign Up</h1>

            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; margin-bottom: 0.4rem; color: #b3b3b3;">Name</label>
                <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" 
                    style="width: 100%; padding: 0.75rem; background: #333; border: none; border-radius: 4px; color: white;">
                <x-input-error :messages="$errors->get('name')" style="color: #e50914; font-size: 0.8rem; margin-top: 0.25rem;" />
            </div>

            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; margin-bottom: 0.4rem; color: #b3b3b3;">Email</label>
                <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" 
                    style="width: 100%; padding: 0.75rem; background: #333; border: none; border-radius: 4px; color: white;">
                <x-input-error :messages="$errors->get('email')" style="color: #e50914; font-size: 0.8rem; margin-top: 0.25rem;" />
            </div>

            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; margin-bottom: 0.4rem; color: #b3b3b3;">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    style="width: 100%; padding: 0.75rem; background: #333; border: none; border-radius: 4px; color: white;">
                <x-input-error :messages="$errors->get('password')" style="color: #e50914; font-size: 0.8rem; margin-top: 0.25rem;" />
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.4rem; color: #b3b3b3;">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    style="width: 100%; padding: 0.75rem; background: #333; border: none; border-radius: 4px; color: white;">
                <x-input-error :messages="$errors->get('password_confirmation')" style="color: #e50914; font-size: 0.8rem; margin-top: 0.25rem;" />
            </div>

            <button type="submit" class="nf-btn nf-btn-danger" style="width: 100%; padding: 0.8rem; font-size: 1rem;">
                Register
            </button>

            <p style="margin-top: 2rem; color: #737373;">
                Already have an account? <a href="{{ route('login') }}" style="color: #fff; text-decoration: none;">Sign in now</a>.
            </p>
        </form>
    </main>
</x-layouts.netflix>
