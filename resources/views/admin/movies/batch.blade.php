<x-layouts.netflix title="Admin - Batch Submission">
    <header class="nf-header">
        <div style="display: flex; align-items: center; gap: 2rem;">
            <a class="nf-logo" href="{{ route('home') }}">HABESHAFLIX ADMIN</a>
            <nav class="nf-nav">
                <a href="{{ route('admin.dashboard') }}">Moderation</a>
                <a class="active" href="{{ route('admin.movies.index') }}">Movies</a>
                <a href="{{ route('admin.casts.index') }}">Casts</a>
                <a href="{{ route('admin.genres.index') }}">Genres</a>
            </nav>
        </div>
        <a class="nf-btn nf-btn-muted nf-small-btn" href="{{ route('home') }}">Back to Site</a>
    </header>

    <main class="nf-content" style="max-width: 800px; margin: 2rem auto;">
        <div class="nf-card" style="padding: 2rem;">
            <h1 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 2rem;">Batch Movie Submission</h1>
            
            <p style="color: #b3b3b3; margin-bottom: 2rem;">Paste multiple YouTube URLs below, one per line. We'll automatically fetch the titles for you to review.</p>

            <form action="{{ route('admin.movies.batch.preview') }}" method="POST" style="display: grid; gap: 1.5rem;">
                @csrf

                <div>
                    <label for="urls" style="display: block; margin-bottom: .5rem; font-weight: 500;">YouTube URLs (one per line)</label>
                    <textarea 
                        name="urls" 
                        id="urls" 
                        rows="12" 
                        required
                        style="width: 100%; padding: .75rem; border-radius: .3rem; background: #333; border: 1px solid #444; color: #fff; resize: vertical; font-family: monospace;"
                        placeholder="https://www.youtube.com/watch?v=...&#10;https://youtu.be/..."
                    >{{ old('urls') }}</textarea>
                    @error('urls')
                        <p style="color: #e50914; font-size: .85rem; margin-top: .25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="nf-btn" style="flex: 1; padding: .9rem; font-size: 1.1rem; font-weight: 600;">
                        Preview & Fetch Titles
                    </button>
                    <a href="{{ route('admin.movies.index') }}" class="nf-btn nf-btn-muted" style="text-decoration: none; display: flex; align-items: center; justify-content: center; padding: 0 2rem;">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
</x-layouts.netflix>
