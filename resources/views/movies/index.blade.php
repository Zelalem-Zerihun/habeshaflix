<x-layouts.netflix title="HabeshaFlix - Home">
    <header class="nf-header">
        <a class="nf-logo" href="{{ route('home') }}">HABESHAFLIX</a>
        <nav class="nf-nav">
            <a class="active" href="{{ route('home') }}">Home</a>
            <a href="{{ route('browse') }}">Browse Demo</a>
            @auth
                <a href="{{ route('movies.create') }}" style="color: #e50914; font-weight: bold;">Submit Movie</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Sign Out</a>
                </form>
            @else
                <a href="{{ route('login') }}">Sign In</a>
            @endauth
        </nav>
    </header>

    <main class="nf-content" style="margin-top: 0; padding-top: 1.5rem;">
        @if (session('status'))
            <div style="background: #1f2937; border-left: 4px solid #10b981; color: #fff; padding: 1rem; margin-bottom: 2rem; border-radius: .3rem;">
                {{ session('status') }}
            </div>
        @endif

        <section class="nf-row" style="margin-top: 0;">
            <div class="nf-row-header">
                <h1 style="margin: 0; font-size: 1.75rem;">Approved Movies</h1>
            </div>

            @if ($movies->isEmpty())
                <div class="nf-card" style="margin-top: 1rem; padding: 1rem;">
                    <p style="margin: 0; color: #d1d5db;">No approved movies yet. Submit and approve movies to display them here.</p>
                </div>
            @else
                <div class="nf-card-grid">
                    @foreach ($movies as $movie)
                        <article class="nf-card">
                            <a href="{{ route('movies.show', $movie) }}" style="display: block;">
                                <img src="https://img.youtube.com/vi/{{ $movie->youtube_id }}/hqdefault.jpg" alt="{{ $movie->title }} poster">
                            </a>
                            <div class="nf-card-body">
                                <h3>{{ $movie->title }}</h3>
                                <p style="margin: 0 0 .75rem; color: #b3b3b3; font-size: .9rem;">
                                    {{ $movie->year ? $movie->year : 'Year not set' }}
                                </p>
                                <a class="nf-link-btn" href="{{ route('movies.show', $movie) }}">View Details</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
</x-layouts.netflix>
