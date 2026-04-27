<x-layouts.netflix :title="'HabeshaFlix - Watching '.$movie->title">
    <header class="nf-header">
        <a class="nf-logo" href="{{ route('browse') }}">HABESHAFLIX</a>
        <nav class="nf-nav">
            <a href="{{ route('browse') }}">Home</a>
            <a href="{{ route('movies') }}">Movies</a>
        </nav>
        <a class="nf-btn nf-btn-muted nf-small-btn" href="{{ url()->previous() == url()->current() ? route('browse') : url()->previous() }}">Back</a>
    </header>

    <main class="nf-watch">
        <div class="nf-video-container" style="position: relative; width: 100%; padding-top: 56.25%; background: #000;">
            <iframe
                src="https://www.youtube.com/embed/{{ $movie->youtube_id }}"
                title="{{ $movie->title }}"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen
                style="position: absolute; inset: 0; width: 100%; height: 100%; border: 0;"
            ></iframe>
        </div>

        <div class="nf-watch-info" style="padding: 2rem 4%; background: linear-gradient(to bottom, #141414, #000);">
            <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $movie->title }}</h1>
            <div style="display: flex; gap: 1rem; color: #a3a3a3; margin-bottom: 1.5rem; align-items: center;">
                <span style="color: #46d369; font-weight: bold;">{{ rand(90, 99) }}% Match</span>
                <span>{{ $movie->year }}</span>
                <span style="border: 1px solid #a3a3a3; padding: 0 0.4rem; font-size: 0.8rem;">HD</span>
            </div>
            <p style="font-size: 1.1rem; line-height: 1.6; max-width: 800px; color: #e5e5e5;">
                {{ $movie->description ?: 'No description available for this movie.' }}
            </p>
            
            <div style="margin-top: 3rem; border-top: 1px solid #333; padding-top: 2rem;">
                <h2 style="font-size: 1.5rem; margin-bottom: 1.5rem;">Cast</h2>
                @if($movie->castMembers->isEmpty())
                    <p style="color: #6d6d6d;">No cast information available.</p>
                @else
                    <div style="display: flex; flex-wrap: wrap; gap: 2rem;">
                        @foreach($movie->castMembers as $cast)
                            <div style="text-align: center; width: 100px;">
                                @if($cast->image)
                                    <img src="{{ $cast->image }}" alt="{{ $cast->name }}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: 0.75rem; border: 2px solid #333;">
                                @else
                                    <div style="width: 80px; height: 80px; border-radius: 50%; background: #333; margin: 0 auto 0.75rem; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.5rem; color: #fff;">
                                        {{ strtoupper(substr($cast->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div style="font-size: 0.9rem; color: #e5e5e5; line-height: 1.2;">{{ $cast->name }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div style="margin-top: 2rem;">
                <p><span style="color: #6d6d6d;">Genres:</span> {{ $movie->genres->pluck('name')->join(', ') ?: 'N/A' }}</p>
            </div>
        </div>
    </main>
</x-layouts.netflix>
