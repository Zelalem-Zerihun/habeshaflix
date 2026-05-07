<x-layouts.netflix title="Sign Up - HabeshaFlix">
    <header class="nf-header nf-header-landing">
        <a class="nf-logo" href="{{ route('landing') }}">HABESHAFLIX</a>
    </header>

    <main class="nf-signin">
        <form class="nf-form" method="POST" action="{{ route('register') }}">
            @csrf
            <h1>Sign Up</h1>

            <div class="nf-form-group">
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Full Name">
                <x-input-error :messages="$errors->get('name')" class="nf-error" />
            </div>

            <div class="nf-form-group">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Email address">
                <x-input-error :messages="$errors->get('email')" class="nf-error" />
            </div>

            <div class="nf-form-group">
                <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Password">
                <x-input-error :messages="$errors->get('password')" class="nf-error" />
            </div>

            <div class="nf-form-group">
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                <x-input-error :messages="$errors->get('password_confirmation')" class="nf-error" />
            </div>

            <button type="submit" class="nf-btn nf-btn-danger" style="width: 100%; margin-top: 1rem;">
                Register
            </button>

            <p class="nf-form-footer">
                Already have an account? <a href="{{ route('login') }}">Sign in now</a>.
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
