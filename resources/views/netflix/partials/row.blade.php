<section class="nf-row">
    <div class="nf-row-header">
        <h2>{{ $title }}</h2>
    </div>
    <div class="nf-card-grid">
        @forelse ($items as $movie)
            <article class="nf-card">
                <img src="https://img.youtube.com/vi/{{ $movie->youtube_id }}/mqdefault.jpg" alt="{{ $movie->title }} poster">
                <div class="nf-card-body">
                    <h3>{{ $movie->title }}</h3>
                    <div class="nf-card-meta">
                        <span>{{ $movie->year }}</span>
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
            <p style="color: #666; padding: 1rem;">No movies found in this category.</p>
        @endforelse
    </div>
</section>
