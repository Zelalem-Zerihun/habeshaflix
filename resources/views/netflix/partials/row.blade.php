<section class="nf-row">
    <div class="nf-row-header">
        <h2>{{ $title }}</h2>
    </div>
    <div class="nf-card-grid">
        @forelse ($items as $movie)
            @include('netflix.partials.card', ['movie' => $movie])
        @empty
            <p style="color: #666; padding: 1rem;">No movies found in this category.</p>
        @endforelse
    </div>
</section>
