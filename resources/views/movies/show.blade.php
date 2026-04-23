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
                src="https://www.youtube.com/embed/{{ $movie->youtube_id }}"
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

        <div style="display: grid; gap: .75rem; margin-top: 1rem;">
            <p style="margin: 0; color: #d1d5db;">
                <strong style="color: #fff;">Genres:</strong>
                {{ $movie->genres->pluck('name')->join(', ') ?: 'Not set' }}
            </p>
            <p style="margin: 0; color: #d1d5db;">
                <strong style="color: #fff;">Cast:</strong>
                {{ $movie->castMembers->pluck('name')->join(', ') ?: 'Not set' }}
            </p>
            <p style="margin: 0; color: #d1d5db;">
                <strong style="color: #fff;">Submitted by:</strong>
                {{ $movie->creator?->name ?? 'Unknown' }}
            </p>
        </div>
    </main>
</x-layouts.netflix>
