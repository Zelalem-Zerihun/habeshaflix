<article class="nf-card">
    <div class="nf-card-image-wrapper">
        <img src="https://img.youtube.com/vi/{{ $movie->youtube_id }}/mqdefault.jpg" alt="{{ $movie->title }} poster">
        <div class="nf-card-overlay">
            <a href="{{ route('watch', $movie) }}" class="nf-play-button-overlay">
                <svg fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            </a>
        </div>
    </div>
    <div class="nf-card-info">
        <h3 class="nf-card-title">{{ $movie->title }}</h3>
    </div>
    <div class="nf-card-body">
        <h3 class="nf-card-title-hover">{{ $movie->title }}</h3>
        <div class="nf-card-controls">
            <a href="{{ route('watch', $movie) }}" class="nf-circle-btn nf-circle-btn-white" title="Play">
                <svg fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            </a>
            @auth
                <form action="{{ route('watchlist.toggle', $movie) }}" method="POST">
                    @csrf
                    <button type="submit" class="nf-circle-btn nf-circle-btn-outline" title="{{ auth()->user()->watchlistMovies->contains($movie->id) ? 'Remove from My List' : 'Add to My List' }}">
                        @if(auth()->user()->watchlistMovies->contains($movie->id))
                            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                        @else
                            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                        @endif
                    </button>
                </form>
            @endauth
            <a href="{{ route('watch', $movie) }}" class="nf-circle-btn nf-circle-btn-outline" style="margin-left: auto;" title="More Info">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </a>
        </div>
        <div class="nf-card-meta">
            @if($movie->year)
                <span class="nf-year">{{ $movie->year }}</span>
            @endif
            <span class="nf-badge">HD</span>
            <span class="nf-match">{{ rand(90, 99) }}% Match</span>
        </div>
    </div>
</article>

<style>
    .nf-card-image-wrapper {
        position: relative;
    }
    .nf-card-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .nf-card:hover .nf-card-overlay {
        opacity: 1;
    }
    .nf-play-button-overlay {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        border: 2px solid #fff;
    }
    .nf-play-button-overlay svg {
        width: 24px;
        height: 24px;
        margin-left: 2px;
    }
    .nf-card-info {
        padding: 0.75rem 0.5rem 0.25rem;
        transition: opacity 0.2s;
    }
    .nf-card:hover .nf-card-info {
        opacity: 0;
    }
    .nf-card-title {
        margin: 0;
        font-size: 0.9rem;
        font-weight: 500;
        color: #e5e5e5;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .nf-card-title-hover {
        margin: 0 0 0.8rem;
        font-size: 0.9rem;
        font-weight: 700;
        color: #fff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .nf-card-controls {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        margin-bottom: 0.8rem;
    }
    .nf-circle-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        padding: 0;
        background: transparent;
    }
    .nf-circle-btn svg {
        width: 20px;
        height: 20px;
    }
    .nf-circle-btn-white {
        background: #fff;
        color: #000;
        border: none;
    }
    .nf-circle-btn-white:hover {
        background: #e6e6e6;
    }
    .nf-circle-btn-outline {
        border: 2px solid rgba(255,255,255,0.5);
        color: #fff;
    }
    .nf-circle-btn-outline:hover {
        border-color: #fff;
        background: rgba(255,255,255,0.1);
    }
    .nf-card-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.8rem;
        margin-top: 0.5rem;
    }
    .nf-match {
        color: #46d369;
        font-weight: 700;
    }
    .nf-year {
        color: #fff;
    }
    .nf-badge {
        border: 1px solid rgba(255,255,255,0.4);
        padding: 0 4px;
        font-size: 0.6rem;
        border-radius: 2px;
    }
</style>


