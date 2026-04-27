<x-layouts.netflix :title="'HabeshaFlix - '.$movie->title">
    <header class="nf-header">
        <a class="nf-logo" href="{{ route('home') }}">HABESHAFLIX</a>
        <a class="nf-btn nf-btn-muted nf-small-btn" href="{{ route('home') }}">Back to Home</a>
    </header>

    <main class="nf-watch">
        <h1 style="margin-top: 0;">{{ $movie->title }}</h1>
        <p style="color: #d1d5db;">
            {{ $movie->year ? $movie->year.' • ' : '' }}
            {{ ucfirst($movie->status) }}
        </p>

        <div style="position: relative; width: 100%; padding-top: 56.25%; border-radius: .6rem; overflow: hidden; border: 1px solid #2a2a2a;">
            <iframe
                src="https://www.youtube-nocookie.com/embed/{{ $movie->youtube_id }}"
                title="{{ $movie->title }}"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin"
                allowfullscreen
                style="position: absolute; inset: 0; width: 100%; height: 100%; border: 0;"
            ></iframe>
        </div>

        @if ($movie->description)
            <p style="line-height: 1.6; color: #e5e7eb;">{{ $movie->description }}</p>
        @endif

        <div style="display: grid; gap: 1.5rem; margin-top: 2rem; border-top: 1px solid #333; pt-1.5rem;">
            <div>
                <strong style="color: #fff; display: block; margin-bottom: 0.5rem;">Genres</strong>
                <p style="margin: 0; color: #d1d5db;">
                    {{ $movie->genres->pluck('name')->join(', ') ?: 'Not set' }}
                </p>
            </div>

            <div>
                <strong style="color: #fff; display: block; margin-bottom: 1rem;">Cast</strong>
                @if($movie->castMembers->isEmpty())
                    <p style="color: #d1d5db;">Not set</p>
                @else
                    <div style="display: flex; flex-wrap: wrap; gap: 1.5rem;">
                        @foreach($movie->castMembers as $cast)
                            <div style="text-align: center; width: 80px;">
                                @if($cast->image)
                                    <img src="{{ $cast->image }}" alt="{{ $cast->name }}" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; margin-bottom: 0.5rem; border: 2px solid #333;">
                                @else
                                    <div style="width: 60px; height: 60px; border-radius: 50%; background: #333; margin: 0 auto 0.5rem; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; color: #fff;">
                                        {{ strtoupper(substr($cast->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div style="font-size: 0.8rem; color: #d1d5db; line-height: 1.2;">{{ $cast->name }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <strong style="color: #fff; display: block; margin-bottom: 0.5rem;">Submitted by</strong>
                <p style="margin: 0; color: #d1d5db;">
                    {{ $movie->creator?->name ?? 'Unknown' }}
                </p>
            </div>
        </div>
    </main>
</x-layouts.netflix>
