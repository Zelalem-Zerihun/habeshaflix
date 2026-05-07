<x-layouts.netflix :title="'HabeshaFlix - Watching '.$movie->title">
    <header class="nf-header scrolled">
        <div style="display: flex; align-items: center;">
            <a class="nf-logo" href="{{ route('browse') }}">HABESHAFLIX</a>
            <nav class="nf-nav">
                <a href="{{ route('browse') }}">Home</a>
                <a href="{{ route('movies') }}">Movies</a>
            </nav>
        </div>
        <a class="nf-btn nf-btn-muted nf-small-btn" href="{{ url()->previous() == url()->current() ? route('browse') : url()->previous() }}">
            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back
        </a>
    </header>

    <main class="nf-watch-container">
        <div class="nf-video-wrapper">
            <iframe
                src="https://www.youtube.com/embed/{{ $movie->youtube_id }}?autoplay=1"
                title="{{ $movie->title }}"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen
            ></iframe>
        </div>

        <div class="nf-watch-content">
            <div class="nf-watch-main">
                <h1 class="nf-watch-title">{{ $movie->title }}</h1>
                <div class="nf-watch-meta">
                    <span class="nf-match">{{ rand(90, 99) }}% Match</span>
                    <span>{{ $movie->year }}</span>
                    <span class="nf-badge">HD</span>
                    @auth
                        <form action="{{ route('watchlist.toggle', $movie) }}" method="POST">
                            @csrf
                            <button type="submit" class="nf-btn nf-btn-muted nf-small-btn">
                                @if(auth()->user()->watchlistMovies->contains($movie->id))
                                    <span>✓</span> My List
                                @else
                                    <span style="font-size: 1.2rem;">+</span> My List
                                @endif
                            </button>
                        </form>
                    @endauth
                </div>
                <p class="nf-watch-description">
                    {{ $movie->description ?: 'No description available for this movie.' }}
                </p>
            </div>

            <aside class="nf-watch-side">
                <div class="nf-watch-details">
                    <div><span class="nf-label">Cast:</span> {{ $movie->castMembers->pluck('name')->take(3)->join(', ') ?: 'N/A' }}</div>
                    <div><span class="nf-label">Genres:</span> {{ $movie->genres->pluck('name')->join(', ') ?: 'N/A' }}</div>
                </div>
            </aside>
        </div>

        @if(!$movie->castMembers->isEmpty())
            <section class="nf-cast-section">
                <h2 class="nf-section-title">Cast</h2>
                <div class="nf-cast-grid">
                    @foreach($movie->castMembers as $cast)
                        <div class="nf-cast-card">
                            <div class="nf-cast-avatar">
                                @if($cast->image)
                                    <img src="{{ $cast->image }}" alt="{{ $cast->name }}">
                                @else
                                    <div class="nf-cast-initial">{{ strtoupper(substr($cast->name, 0, 1)) }}</div>
                                @endif
                            </div>
                            <div class="nf-cast-name">{{ $cast->name }}</div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </main>

    <style>
        .nf-watch-container {
            padding-bottom: 5rem;
        }
        .nf-video-wrapper {
            position: relative;
            width: 100%;
            padding-top: 56.25%; /* 16:9 Aspect Ratio */
            background: #000;
        }
        .nf-video-wrapper iframe {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
        .nf-watch-content {
            padding: 2rem 4%;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 4rem;
        }
        .nf-watch-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }
        .nf-watch-meta {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }
        .nf-watch-description {
            font-size: 1.25rem;
            line-height: 1.6;
            color: #e5e5e5;
        }
        .nf-watch-details {
            display: flex;
            flex-column: column;
            gap: 0.75rem;
            font-size: 0.9rem;
            color: #fff;
        }
        .nf-label {
            color: #6d6d6d;
        }
        .nf-cast-section {
            padding: 0 4% 4rem;
        }
        .nf-section-title {
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            color: #fff;
        }
        .nf-cast-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 2rem;
        }
        .nf-cast-card {
            text-align: center;
        }
        .nf-cast-avatar {
            width: 100px;
            height: 100px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            overflow: hidden;
            background: #222;
            border: 2px solid #333;
            transition: transform 0.3s;
        }
        .nf-cast-card:hover .nf-cast-avatar {
            transform: scale(1.05);
            border-color: #666;
        }
        .nf-cast-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .nf-cast-initial {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
        }
        .nf-cast-name {
            font-size: 0.95rem;
            font-weight: 500;
        }
        @media (max-width: 900px) {
            .nf-watch-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .nf-watch-title { font-size: 2rem; }
        }
    </style>
</x-layouts.netflix>
