<x-layouts.netflix title="Manage Genres">
    <header class="nf-header">
        <div style="display: flex; align-items: center; gap: 2rem;">
            <a class="nf-logo" href="{{ route('home') }}">HABESHAFLIX ADMIN</a>
            <nav class="nf-nav">
                <a href="{{ route('admin.dashboard') }}">Moderation</a>
                <a href="{{ route('admin.movies.index') }}">Movies</a>
                <a href="{{ route('admin.casts.index') }}">Casts</a>
                <a class="active" href="{{ route('admin.genres.index') }}">Genres</a>
            </nav>
        </div>
        <a class="nf-btn nf-btn-muted nf-small-btn" href="{{ route('home') }}">Back to Site</a>
    </header>

    <main class="nf-content">
        <h2 style="margin-bottom: 1.5rem;">Movie Genres</h2>
        <div class="nf-card" style="padding: 2rem;">
            <p style="color: #b3b3b3; margin-bottom: 2rem;">Below is the list of pre-defined movie genres available in the system.</p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                @foreach($genres as $genre)
                    <div style="background: #333; padding: 1rem; border-radius: 4px; text-align: center; border: 1px solid #444;">
                        {{ $genre->name }}
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</x-layouts.netflix>
