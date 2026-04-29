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

    <main class="nf-content" style="max-width: 1100px; margin: 2rem auto;">
        <div class="nf-card" style="padding: 2rem;">
            <h1 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 2rem;">Review & Complete Metadata</h1>
            
            <p style="color: #b3b3b3; margin-bottom: 2rem;">Fill in the details for each movie before final submission. You can selectively skip or delete items if needed.</p>

            @if(empty($movies))
                <div style="background: rgba(229, 9, 20, 0.1); border: 1px solid #e50914; color: #f87171; padding: 1.5rem; border-radius: .3rem; text-align: center;">
                    No valid YouTube URLs were found. <a href="{{ route('admin.movies.batch') }}" style="color: #fff; text-decoration: underline;">Go back and try again.</a>
                </div>
            @else
                <form action="{{ route('admin.movies.batch.store') }}" method="POST">
                    @csrf
                    
                    <div style="display: grid; gap: 2rem; margin-bottom: 3rem;">
                        @foreach($movies as $index => $movie)
                            <div class="batch-movie-card" style="background: #1a1a1a; border: 1px solid #333; border-radius: 0.75rem; overflow: hidden; position: relative;">
                                <div style="display: flex; flex-direction: column; md:flex-row;">
                                    <!-- Left: Thumbnail and Basic Info -->
                                    <div style="padding: 1.5rem; background: #222; border-right: 1px solid #333; width: 250px; flex-shrink: 0;">
                                        <div style="position: relative; margin-bottom: 1rem;">
                                            <img src="https://img.youtube.com/vi/{{ $movie['youtube_id'] }}/mqdefault.jpg" style="width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: 4px; box-shadow: 0 4px 10px rgba(0,0,0,0.5);">
                                            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; border-radius: 4px; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);"></div>
                                        </div>
                                        <div style="font-size: 0.8rem; color: #888; margin-bottom: 1rem; word-break: break-all;">
                                            {{ $movie['youtube_url'] }}
                                        </div>
                                        <button type="button" onclick="this.closest('.batch-movie-card').remove()" style="width: 100%; padding: 0.5rem; background: rgba(229, 9, 20, 0.1); border: 1px solid #e50914; color: #e50914; border-radius: 0.25rem; font-size: 0.8rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#e50914'; this.style.color='#fff'">
                                            Remove from Batch
                                        </button>
                                    </div>

                                    <!-- Right: Metadata Fields -->
                                    <div style="padding: 1.5rem; flex: 1; display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                        <input type="hidden" name="movies[{{ $index }}][youtube_id]" value="{{ $movie['youtube_id'] }}">
                                        <input type="hidden" name="movies[{{ $index }}][youtube_url]" value="{{ $movie['youtube_url'] }}">
                                        
                                        <div style="grid-column: span 2;">
                                            <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #b3b3b3; margin-bottom: 0.5rem;">Movie Title</label>
                                            <input 
                                                type="text" 
                                                name="movies[{{ $index }}][title]" 
                                                value="{{ $movie['title'] }}" 
                                                style="width: 100%; padding: .75rem; border-radius: .3rem; background: #333; border: 1px solid #444; color: #fff;"
                                                required
                                            >
                                        </div>

                                        <div style="grid-column: span 1;">
                                            <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #b3b3b3; margin-bottom: 0.5rem;">Release Year</label>
                                            <input 
                                                type="number" 
                                                name="movies[{{ $index }}][year]" 
                                                min="1900" 
                                                max="{{ date('Y') + 5 }}"
                                                style="width: 100%; padding: .75rem; border-radius: .3rem; background: #333; border: 1px solid #444; color: #fff;"
                                                placeholder="e.g. 2024"
                                            >
                                        </div>

                                        <div style="grid-column: span 2;">
                                            <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #b3b3b3; margin-bottom: 0.5rem;">Description</label>
                                            <textarea 
                                                name="movies[{{ $index }}][description]" 
                                                rows="3"
                                                style="width: 100%; padding: .75rem; border-radius: .3rem; background: #333; border: 1px solid #444; color: #fff; resize: vertical;"
                                                placeholder="Brief summary of the movie..."
                                            ></textarea>
                                        </div>

                                        <!-- Genres -->
                                        <div style="grid-column: span 2;">
                                            <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #b3b3b3; margin-bottom: 1rem;">Select Genres</label>
                                            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                                @foreach($genres as $genre)
                                                    <label style="cursor: pointer; display: flex; align-items: center; gap: 0.4rem; background: #222; padding: 0.4rem 0.8rem; border-radius: 2rem; border: 1px solid #444; font-size: 0.8rem; transition: all 0.2s;">
                                                        <input type="checkbox" name="movies[{{ $index }}][genres][]" value="{{ $genre->id }}" style="accent-color: #e50914;">
                                                        <span>{{ $genre->name }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Cast Members -->
                                        <div style="grid-column: span 2;">
                                            <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #b3b3b3; margin-bottom: 1rem;">Select Cast Members</label>
                                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 0.5rem; max-height: 200px; overflow-y: auto; padding: 1rem; background: #111; border-radius: 0.5rem; border: 1px solid #333;">
                                                @foreach($casts as $cast)
                                                    <label style="cursor: pointer; display: flex; align-items: center; gap: 0.6rem; padding: 0.3rem; border-radius: 0.3rem; transition: background 0.2s;" onmouseover="this.style.background='#222'" onmouseout="this.style.background='transparent'">
                                                        <input type="checkbox" name="movies[{{ $index }}][casts][]" value="{{ $cast->id }}" style="accent-color: #e50914;">
                                                        <span style="font-size: 0.8rem; color: #d1d5db; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $cast->name }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div style="position: sticky; bottom: 0; left: 0; right: 0; background: #000; border-top: 1px solid #333; padding: 1.5rem; display: flex; gap: 1rem; z-index: 100;">
                        <button type="submit" class="nf-btn" style="flex: 2; padding: 1.1rem; font-size: 1.2rem; font-weight: 600; box-shadow: 0 5px 20px rgba(229, 9, 20, 0.3);">
                            Confirm & Save All Movies
                        </button>
                        <a href="{{ route('admin.movies.batch') }}" class="nf-btn nf-btn-muted" style="flex: 1; text-decoration: none; display: flex; align-items: center; justify-content: center; font-weight: 500;">
                            Cancel Batch
                        </a>
                    </div>
                </form>
            @endif
        </div>
    </main>
</x-layouts.netflix>
