<x-layouts.netflix title="Admin - Review Batch Submission">
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

    <main class="nf-content" style="max-width: 1000px; margin: 2rem auto;">
        <div class="nf-card" style="padding: 2rem;">
            <h1 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 2rem;">Review & Confirm</h1>
            
            <p style="color: #b3b3b3; margin-bottom: 2rem;">We've fetched the titles for the URLs you provided. Please review them and edit the titles if necessary before final submission.</p>

            @if(empty($movies))
                <div style="background: rgba(229, 9, 20, 0.1); border: 1px solid #e50914; color: #f87171; padding: 1.5rem; border-radius: .3rem; text-align: center;">
                    No valid YouTube URLs were found. <a href="{{ route('admin.movies.batch') }}" style="color: #fff; text-decoration: underline;">Go back and try again.</a>
                </div>
            @else
                <form action="{{ route('admin.movies.batch.store') }}" method="POST">
                    @csrf
                    
                    <div style="display: grid; gap: 1rem; margin-bottom: 2rem;">
                        @foreach($movies as $index => $movie)
                            <div style="background: #222; border: 1px solid #333; border-radius: 0.5rem; overflow: hidden; display: flex; align-items: center; gap: 1.5rem; padding: 1rem;">
                                <div style="width: 120px; flex-shrink: 0;">
                                    <img src="https://img.youtube.com/vi/{{ $movie['youtube_id'] }}/mqdefault.jpg" style="width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: 4px;">
                                </div>
                                
                                <div style="flex: 1; display: grid; gap: 0.5rem;">
                                    <input type="hidden" name="movies[{{ $index }}][youtube_id]" value="{{ $movie['youtube_id'] }}">
                                    <input type="hidden" name="movies[{{ $index }}][youtube_url]" value="{{ $movie['youtube_url'] }}">
                                    
                                    <div>
                                        <label style="display: block; font-size: 0.75rem; color: #b3b3b3; margin-bottom: 0.25rem;">Title</label>
                                        <input 
                                            type="text" 
                                            name="movies[{{ $index }}][title]" 
                                            value="{{ $movie['title'] }}" 
                                            style="width: 100%; padding: .5rem; border-radius: .25rem; background: #333; border: 1px solid #444; color: #fff;"
                                            required
                                        >
                                    </div>
                                    <div style="font-size: 0.8rem; color: #888; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        URL: {{ $movie['youtube_url'] }}
                                    </div>
                                </div>

                                <button type="button" onclick="this.parentElement.remove()" style="background: transparent; border: none; color: #888; cursor: pointer; padding: 0.5rem; transition: color 0.2s;" onmouseover="this.style.color='#e50914'" onmouseout="this.style.color='#888'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <div style="display: flex; gap: 1rem; border-top: 1px solid #333; padding-top: 2rem;">
                        <button type="submit" class="nf-btn" style="flex: 2; padding: .9rem; font-size: 1.1rem; font-weight: 600;">
                            Confirm & Submit {{ count($movies) }} Movies
                        </button>
                        <a href="{{ route('admin.movies.batch') }}" class="nf-btn nf-btn-muted" style="flex: 1; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                            Go Back
                        </a>
                    </div>
                </form>
            @endif
        </div>
    </main>
</x-layouts.netflix>
