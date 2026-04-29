<x-layouts.netflix title="HabeshaFlix - Search">
    <header class="nf-header">
        <a class="nf-logo" href="{{ route('browse') }}">HABESHAFLIX</a>
        <nav class="nf-nav">
            <a href="{{ route('browse') }}">Home</a>
            <a href="{{ route('movies') }}">Movies</a>
            <a href="{{ route('series') }}">Series</a>
            <a href="{{ route('new-popular') }}">New & Popular</a>
            <a href="{{ route('my-list') }}">My List</a>
        </nav>
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <form action="{{ route('search') }}" method="GET" class="nf-search-form" style="position: relative;">
                <input 
                    type="text" 
                    name="q" 
                    placeholder="Titles, actors..." 
                    value="{{ $query }}"
                    style="background: rgba(0,0,0,0.75); border: 1px solid #333; color: #fff; padding: 0.4rem 0.8rem 0.4rem 2.2rem; border-radius: 4px; font-size: 0.85rem; width: 280px; transition: width 0.3s ease, border-color 0.3s ease;"
                >
                <svg style="position: absolute; left: 0.7rem; top: 50%; transform: translateY(-50%); width: 1rem; height: 1rem; color: #999;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </form>

            @auth
                <div class="nf-user-dropdown" style="position: relative;">
                    <button style="background: transparent; border: none; color: #fff; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; font-weight: 500;">
                        <div style="width: 32px; height: 32px; background: #e50914; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.9rem;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span style="font-size: 0.9rem;">{{ auth()->user()->name }}</span>
                        <span style="font-size: 0.6rem;">▼</span>
                    </button>
                    <div class="nf-dropdown-content" style="display: none; position: absolute; top: 100%; right: 0; background: rgba(0,0,0,0.9); border: 1px solid #333; min-width: 160px; border-radius: 4px; padding: 0.5rem 0; z-index: 100;">
                        <a href="{{ route('profile.edit') }}" style="display: block; padding: 0.6rem 1rem; font-size: 0.85rem; color: #fff;">Edit Profile</a>
                        <a href="{{ route('dashboard') }}" style="display: block; padding: 0.6rem 1rem; font-size: 0.85rem; color: #fff;">Dashboard</a>
                        <div style="height: 1px; background: #333; margin: 0.4rem 0;"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="width: 100%; text-align: left; background: transparent; border: none; color: #fff; padding: 0.6rem 1rem; font-size: 0.85rem; cursor: pointer;">Sign Out</button>
                        </form>
                    </div>
                </div>
            @else
                <a class="nf-btn nf-btn-danger nf-small-btn" href="{{ route('login') }}">Sign In</a>
            @endauth
        </div>
    </header>

    <main class="nf-content" style="padding-top: 2rem;">
        <div class="nf-row">
            <div class="nf-row-header" style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.5rem; color: #fff;">
                    @if($query)
                        Search results for: <span style="color: var(--danger);">"{{ $query }}"</span>
                    @else
                        Explore our library
                    @endif
                </h2>
                <span style="color: var(--muted);">{{ $movies->count() }} results found</span>
            </div>

            <div class="nf-card-grid">
                @forelse ($movies as $movie)
                    <article class="nf-card">
                        <img src="https://img.youtube.com/vi/{{ $movie->youtube_id }}/mqdefault.jpg" alt="{{ $movie->title }} poster">
                        <div class="nf-card-body">
                            <h3>{{ $movie->title }}</h3>
                            <div class="nf-card-meta">
                                <span>{{ $movie->year }}</span>
                                @if($movie->genres->isNotEmpty())
                                    <span style="margin-left: 0.5rem; color: #6d6d6d;">• {{ $movie->genres->first()->name }}</span>
                                @endif
                            </div>
                            <div style="display: flex; gap: 0.5rem; align-items: center; margin-top: 0.8rem;">
                                <a class="nf-link-btn" href="{{ route('watch', $movie) }}" style="background: #fff; color: #000; font-weight: bold; border: none;">Play</a>
                                
                                @auth
                                    <form action="{{ route('watchlist.toggle', $movie) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="nf-link-btn" style="background: rgba(109, 109, 110, 0.7); color: #fff; border: none; cursor: pointer;">
                                            {{ auth()->user()->watchlistMovies->contains($movie->id) ? '✓ My List' : '+ My List' }}
                                        </button>
                                    </form>
                                @endauth
                            </div>
                        </div>
                    </article>
                @empty
                    <div style="text-align: center; padding: 5rem 0; width: 100%; grid-column: 1 / -1;">
                        <h3 style="font-size: 1.2rem; color: #fff; margin-bottom: 0.5rem;">Your search for "{{ $query }}" did not have any matches.</h3>
                        <p style="color: #6d6d6d;">Suggestions:</p>
                        <ul style="color: #6d6d6d; list-style: none; padding: 0; margin-top: 1rem; line-height: 1.8;">
                            <li>Try different keywords</li>
                            <li>Looking for a movie or TV show?</li>
                            <li>Try using a movie, TV show title, or an actor</li>
                        </ul>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    <style>
        .nf-user-dropdown:hover .nf-dropdown-content {
            display: block !important;
        }
        .nf-dropdown-content a:hover {
            text-decoration: underline;
            background: rgba(255,255,255,0.1);
        }
    </style>
</x-layouts.netflix>
