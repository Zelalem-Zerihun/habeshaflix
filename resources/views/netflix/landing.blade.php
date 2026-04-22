<x-layouts.netflix title="HabeshaFlix - Unlimited Entertainment">
    <header class="nf-header nf-header-landing">
        <a class="nf-logo" href="{{ route('landing') }}">HABESHAFLIX</a>
        <a class="nf-btn nf-btn-danger" href="{{ route('signin') }}">Sign In</a>
    </header>

    <main class="nf-hero-center">
        <h1>Unlimited movies, series, and more.</h1>
        <p>Watch anywhere. Cancel anytime.</p>
        <div class="nf-actions">
            <a class="nf-btn nf-btn-danger" href="{{ route('profiles') }}">Get Started</a>
            <a class="nf-btn nf-btn-muted" href="{{ route('browse') }}">Browse Demo</a>
        </div>
    </main>
</x-layouts.netflix>
