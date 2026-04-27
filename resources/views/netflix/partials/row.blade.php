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
                    <a class="nf-link-btn" href="{{ route('watch', $movie) }}">Watch</a>
                </div>
            </article>
        @empty
            <p style="color: #666; padding: 1rem;">No movies found in this category.</p>
        @endforelse
    </div>
</section>
