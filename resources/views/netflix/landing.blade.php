<x-layouts.netflix title="HabeshaFlix - Unlimited Entertainment">
    <header class="nf-header nf-header-landing">
        <a class="nf-logo" href="{{ route('landing') }}">HABESHAFLIX</a>
        @auth
            <div style="display: flex; gap: 1rem; align-items: center;">
                @if(auth()->user()->isAdmin())
                    <a class="nf-btn nf-btn-muted nf-small-btn" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                @endif
                <a class="nf-btn nf-btn-danger" href="{{ route('browse') }}">Browse</a>
            </div>
        @else
            <a class="nf-btn nf-btn-danger" href="{{ route('login') }}">Sign In</a>
        @endauth
    </header>

    <main class="nf-hero-center">
        <h1>Unlimited movies, series, and more.</h1>
        <p>Watch anywhere. Cancel anytime.</p>
        <div class="nf-actions">
            <a class="nf-btn nf-btn-danger" href="{{ route('register') }}">Get Started</a>
            <a class="nf-btn nf-btn-muted" href="{{ route('browse') }}">Browse Demo</a>
        </div>
    </main>
</x-layouts.netflix>
