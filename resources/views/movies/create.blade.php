<x-layouts.netflix title="HabeshaFlix - Submit Movie">
    <!-- Fallback for Alpine.js if local build is failing -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <header class="nf-header">
        <a class="nf-logo" href="{{ route('home') }}">HABESHAFLIX</a>
        <a class="nf-btn nf-btn-muted nf-small-btn" href="{{ route('home') }}">Back to Home</a>
    </header>

    <main class="nf-content" style="max-width: 600px; margin: 2rem auto;">
        <div class="nf-card" style="padding: 2rem;">
            <h1 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 2rem;">Submit a Movie</h1>
            
            <p style="color: #b3b3b3; margin-bottom: 2rem;">Share your favorite movies with the community. Once submitted, our team will review it for approval.</p>

            <form 
                id="movieForm"
                action="{{ route('movies.store') }}" 
                method="POST" 
                style="display: grid; gap: 1.5rem;"
                x-data="movieSubmitForm()"
            >
                @csrf

                <div>
                    <label for="youtube_url" style="display: block; margin-bottom: .5rem; font-weight: 500;">YouTube URL</label>
                    <div style="display: flex; gap: 0.5rem; align-items: flex-start;">
                        <div style="position: relative; flex: 1;">
                            <input 
                                type="url" 
                                name="youtube_url" 
                                id="youtube_url" 
                                x-model="youtubeUrl"
                                @input.debounce.1000ms="fetchTitle()"
                                required
                                style="width: 100%; padding: .75rem; border-radius: .3rem; background: #333; border: 1px solid #444; color: #fff;"
                                placeholder="Paste YouTube link here..."
                            >
                            <!-- Spinner: Hidden by default with display:none -->
                            <div x-show="isFetching" style="display: none; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                <svg class="nf-spinner" viewBox="0 0 50 50" style="width: 20px; height: 20px;">
                                    <circle cx="25" cy="25" r="20" fill="none" stroke="#e50914" stroke-width="5"></circle>
                                </svg>
                            </div>
                        </div>
                        <button 
                            type="button" 
                            @click="fetchTitle()" 
                            class="nf-btn" 
                            style="padding: 0 1.2rem; white-space: nowrap; height: 48px; min-width: 120px; display: flex; align-items: center; justify-content: center;"
                            :disabled="isFetching"
                        >
                            <span x-show="!isFetching">Fetch Title</span>
                            <span x-show="isFetching">...</span>
                        </button>
                    </div>
                    <p x-show="fetchError" x-text="fetchError" style="display: none; color: #e50914; font-size: .85rem; margin-top: .5rem; font-weight: 500;"></p>
                    @error('youtube_url')
                        <p style="color: #e50914; font-size: .85rem; margin-top: .25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="title" style="display: block; margin-bottom: .5rem; font-weight: 500;">Movie Title</label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        x-model="movieTitle"
                        required
                        style="width: 100%; padding: .75rem; border-radius: .3rem; background: #333; border: 1px solid #444; color: #fff;"
                        placeholder="Title will appear here (you can edit it)"
                    >
                    @error('title')
                        <p style="color: #e50914; font-size: .85rem; margin-top: .25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <script>
                    function movieSubmitForm() {
                        return {
                            movieTitle: '{{ old('title', '') }}',
                            youtubeUrl: '{{ old('youtube_url', '') }}',
                            isFetching: false,
                            fetchError: '',
                            selectedGenres: {!! json_encode(old('genres', [])) !!},
                            selectedCasts: {!! json_encode(old('casts', [])) !!},
                            async fetchTitle() {
                                if (!this.youtubeUrl || this.youtubeUrl.length < 10) {
                                    this.fetchError = 'Please enter a valid YouTube URL.';
                                    return;
                                }
                                
                                this.isFetching = true;
                                this.fetchError = '';
                                
                                try {
                                    const response = await fetch(`{{ route('movies.fetch-title') }}?url=${encodeURIComponent(this.youtubeUrl)}`);
                                    const data = await response.json();
                                    
                                    if (data.title) {
                                        this.movieTitle = data.title;
                                        this.fetchError = '';
                                    } else {
                                        this.fetchError = data.error || 'Could not fetch title.';
                                    }
                                } catch (err) {
                                    this.fetchError = 'Network error. Please try again.';
                                } finally {
                                    this.isFetching = false;
                                }
                            }
                        }
                    }
                </script>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label for="year" style="display: block; margin-bottom: .5rem; font-weight: 500;">Release Year (Optional)</label>
                        <input 
                            type="number" 
                            name="year" 
                            id="year" 
                            value="{{ old('year') }}" 
                            min="1900" 
                            max="{{ date('Y') + 5 }}"
                            style="width: 100%; padding: .75rem; border-radius: .3rem; background: #333; border: 1px solid #444; color: #fff;"
                            placeholder="e.g. 1999"
                        >
                        @error('year')
                            <p style="color: #e50914; font-size: .85rem; margin-top: .25rem;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <div style="margin-bottom: 2rem;">
                        <label style="display: block; margin-bottom: 1rem; font-weight: 500; font-size: 1.1rem;">Select Genres</label>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                            @foreach($genres as $genre)
                                <label style="cursor: pointer; display: flex; align-items: center; gap: 0.5rem; background: #333; padding: 0.5rem 1rem; border-radius: 2rem; border: 1px solid #444; transition: all 0.2s;" :style="selectedGenres.includes('{{ $genre->id }}') ? 'border-color: #e50914; background: rgba(229, 9, 20, 0.1)' : ''">
                                    <input type="checkbox" name="genres[]" value="{{ $genre->id }}" x-model="selectedGenres" style="accent-color: #e50914; width: 1.1rem; height: 1.1rem;">
                                    <span style="color: #fff; font-size: 0.9rem;">{{ $genre->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <label style="display: block; margin-bottom: 1rem; font-weight: 500; font-size: 1.1rem;">Select Cast Members</label>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: 1rem; max-height: 400px; overflow-y: auto; padding: 1rem; background: #222; border-radius: 0.5rem;">
                            @foreach($casts as $cast)
                                <label style="cursor: pointer; position: relative; display: block;">
                                    <div 
                                        :class="selectedCasts.includes('{{ $cast->id }}') ? 'cast-card-active' : 'cast-card'"
                                        class="cast-card"
                                        style="text-align: center; padding: 0.75rem; border-radius: 0.5rem; transition: all 0.2s; position: relative;"
                                    >
                                        <div style="position: absolute; top: 5px; right: 5px; z-index: 2;">
                                            <input type="checkbox" name="casts[]" value="{{ $cast->id }}" x-model="selectedCasts" style="accent-color: #e50914; width: 1.2rem; height: 1.2rem;">
                                        </div>

                                        @if($cast->image)
                                            <img src="{{ $cast->image }}" alt="{{ $cast->name }}" style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; margin-bottom: 0.5rem; border: 2px solid transparent;" :style="selectedCasts.includes('{{ $cast->id }}') ? 'border-color: #e50914' : ''">
                                        @else
                                            <div style="width: 70px; height: 70px; border-radius: 50%; background: #444; margin: 0 auto 0.5rem; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.4rem; color: #fff;" :style="selectedCasts.includes('{{ $cast->id }}') ? 'border: 2px solid #e50914' : ''">
                                                {{ strtoupper(substr($cast->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div style="font-size: 0.85rem; color: #d1d5db; line-height: 1.2;">{{ $cast->name }}</div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <style>
                    .nf-spinner {
                        animation: rotate 2s linear infinite;
                    }
                    .nf-spinner circle {
                        stroke-dasharray: 90, 150;
                        stroke-dashoffset: 0;
                        stroke-linecap: round;
                        animation: dash 1.5s ease-in-out infinite;
                    }
                    @keyframes rotate {
                        100% { transform: rotate(360deg); }
                    }
                    @keyframes dash {
                        0% { stroke-dasharray: 1, 150; stroke-dashoffset: 0; }
                        50% { stroke-dasharray: 90, 150; stroke-dashoffset: -35; }
                        100% { stroke-dasharray: 90, 150; stroke-dashoffset: -124; }
                    }
                    .genre-btn {
                        background: #333;
                        border: 1px solid #444;
                        color: #fff;
                        padding: 0.5rem 1rem;
                        border-radius: 2rem;
                        font-size: 0.9rem;
                        transition: all 0.2s;
                    }
                    .genre-btn:hover {
                        background: #444;
                    }
                    .genre-btn-active {
                        background: #e50914 !important;
                        border-color: #e50914 !important;
                    }
                    .cast-card:hover {
                        background: #333;
                    }
                    .cast-card-active {
                        background: rgba(229, 9, 20, 0.2) !important;
                    }
                </style>

                <div>
                    <label for="description" style="display: block; margin-bottom: .5rem; font-weight: 500;">Description (Optional)</label>
                    <textarea 
                        name="description" 
                        id="description" 
                        rows="4" 
                        style="width: 100%; padding: .75rem; border-radius: .3rem; background: #333; border: 1px solid #444; color: #fff; resize: vertical;"
                        placeholder="Briefly describe the movie..."
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p style="color: #e50914; font-size: .85rem; margin-top: .25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="nf-btn" style="width: 100%; padding: .9rem; font-size: 1.1rem; font-weight: 600;">
                    Submit Movie
                </button>
            </form>
        </div>
    </main>
</x-layouts.netflix>
