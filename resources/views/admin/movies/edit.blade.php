<x-layouts.netflix title="Admin - Edit Movie">
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
        <a class="nf-btn nf-btn-muted nf-small-btn" href="{{ route('admin.movies.index') }}">Cancel</a>
    </header>

    <main class="nf-content" style="max-width: 800px; margin: 2rem auto;">
        <div class="nf-card" style="padding: 2.5rem;">
            <h1 style="margin-top: 0; margin-bottom: 2rem;">Edit Movie: {{ $movie->title }}</h1>

            <form action="{{ route('admin.movies.update', $movie) }}" method="POST" style="display: grid; gap: 1.5rem;">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
                    <div>
                        <label for="title" style="display: block; margin-bottom: .5rem; font-weight: 500;">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $movie->title) }}" required
                            style="width: 100%; padding: .75rem; border-radius: .3rem; background: #333; border: 1px solid #444; color: #fff;">
                        @error('title') <p style="color: #e50914; font-size: .85rem; margin-top: .25rem;">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="year" style="display: block; margin-bottom: .5rem; font-weight: 500;">Year</label>
                        <input type="number" name="year" id="year" value="{{ old('year', $movie->year) }}" min="1900" max="{{ date('Y') + 5 }}"
                            style="width: 100%; padding: .75rem; border-radius: .3rem; background: #333; border: 1px solid #444; color: #fff;">
                    </div>
                </div>

                <div>
                    <label for="youtube_url" style="display: block; margin-bottom: .5rem; font-weight: 500;">YouTube URL</label>
                    <input type="url" name="youtube_url" id="youtube_url" value="{{ old('youtube_url', 'https://www.youtube.com/watch?v='.$movie->youtube_id) }}" required
                        style="width: 100%; padding: .75rem; border-radius: .3rem; background: #333; border: 1px solid #444; color: #fff;"
                        placeholder="https://www.youtube.com/watch?v=...">
                    @error('youtube_url') <p style="color: #e50914; font-size: .85rem; margin-top: .25rem;">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="status" style="display: block; margin-bottom: .5rem; font-weight: 500;">Status</label>
                    <select name="status" id="status" style="width: 100%; padding: .75rem; border-radius: .3rem; background: #333; border: 1px solid #444; color: #fff;">
                        <option value="pending" {{ old('status', $movie->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('status', $movie->status) === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ old('status', $movie->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div x-data="{ 
                    selectedGenres: {{ json_encode(array_map('strval', old('genres', $movie->genres->pluck('id')->toArray()))) }},
                    selectedCasts: {{ json_encode(array_map('strval', old('casts', $movie->castMembers->pluck('id')->toArray()))) }}
                }">
                    <div style="margin-bottom: 2rem;">
                        <label style="display: block; margin-bottom: 1rem; font-weight: 500; font-size: 1.1rem;">Genres</label>
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
                        <label style="display: block; margin-bottom: 1rem; font-weight: 500; font-size: 1.1rem;">Cast Members</label>
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

                <div>
                    <label for="description" style="display: block; margin-bottom: .5rem; font-weight: 500;">Description</label>
                    <textarea name="description" id="description" rows="5" 
                        style="width: 100%; padding: .75rem; border-radius: .3rem; background: #333; border: 1px solid #444; color: #fff; resize: vertical;"
                        placeholder="Briefly describe the movie...">{{ old('description', $movie->description) }}</textarea>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                    <button type="submit" class="nf-btn nf-btn-danger" style="flex: 1; padding: 1rem;">Update Movie</button>
                    <a href="{{ route('admin.movies.index') }}" class="nf-btn nf-btn-muted" style="text-align: center; text-decoration: none; padding: 1rem;">Cancel</a>
                </div>
            </form>
        </div>
    </main>

    <style>
        .genre-btn-active { border-color: #e50914; background: rgba(229, 9, 20, 0.1); }
        .cast-card:hover { background: #333; }
        .cast-card-active { background: rgba(229, 9, 20, 0.2) !important; }
    </style>
</x-layouts.netflix>
