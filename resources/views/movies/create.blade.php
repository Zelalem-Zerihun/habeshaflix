<x-layouts.netflix title="HabeshaFlix - Submit Movie">
    <header class="nf-header">
        <a class="nf-logo" href="{{ route('home') }}">HABESHAFLIX</a>
        <a class="nf-btn nf-btn-muted nf-small-btn" href="{{ route('home') }}">Back to Home</a>
    </header>

    <main class="nf-content" style="max-width: 600px; margin: 2rem auto;">
        <div class="nf-card" style="padding: 2rem;">
            <h1 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 2rem;">Submit a Movie</h1>
            
            <p style="color: #b3b3b3; margin-bottom: 2rem;">Share your favorite movies with the community. Once submitted, our team will review it for approval.</p>

            <form action="{{ route('movies.store') }}" method="POST" style="display: grid; gap: 1.5rem;">
                @csrf

                <div>
                    <label for="title" style="display: block; margin-bottom: .5rem; font-weight: 500;">Movie Title</label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        value="{{ old('title') }}" 
                        required
                        style="width: 100%; padding: .75rem; border-radius: .3rem; background: #333; border: 1px solid #444; color: #fff;"
                        placeholder="e.g. The Matrix"
                    >
                    @error('title')
                        <p style="color: #e50914; font-size: .85rem; margin-top: .25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="youtube_url" style="display: block; margin-bottom: .5rem; font-weight: 500;">YouTube URL</label>
                    <input 
                        type="url" 
                        name="youtube_url" 
                        id="youtube_url" 
                        value="{{ old('youtube_url') }}" 
                        required
                        style="width: 100%; padding: .75rem; border-radius: .3rem; background: #333; border: 1px solid #444; color: #fff;"
                        placeholder="https://www.youtube.com/watch?v=..."
                    >
                    <p style="color: #888; font-size: .8rem; margin-top: .25rem;">We'll automatically extract the video ID.</p>
                    @error('youtube_url')
                        <p style="color: #e50914; font-size: .85rem; margin-top: .25rem;">{{ $message }}</p>
                    @enderror
                </div>

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

                <div x-data="{ 
                    selectedGenres: {{ json_encode(array_map('strval', old('genres', []))) }},
                    selectedCasts: {{ json_encode(array_map('strval', old('casts', []))) }}
                }">
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
