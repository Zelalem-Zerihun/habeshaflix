<x-layouts.admin title="Edit Movie">
    <div class="admin-header">
        <div class="header-title">
            <h1>Edit Movie</h1>
            <p>Modify details for: <strong>{{ $movie->title }}</strong></p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.movies.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="admin-card" style="max-width: 900px; margin: 0 auto;">
        <div class="card-header">
            <h2>Movie Details</h2>
            <span class="badge {{ $movie->status === 'approved' ? 'badge-success' : ($movie->status === 'rejected' ? 'badge-danger' : 'badge-warning') }}">
                Status: {{ ucfirst($movie->status) }}
            </span>
        </div>
        
        <div style="padding: 2rem;">
            <form action="{{ route('admin.movies.update', $movie) }}" method="POST">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Title</label>
                        <input type="text" name="title" value="{{ old('title', $movie->title) }}" required class="form-control">
                        @error('title') <p class="nf-error" style="color: var(--danger); font-size: 0.75rem; margin-top: 0.4rem;">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Release Year</label>
                        <input type="number" name="year" value="{{ old('year', $movie->year) }}" min="1900" max="{{ date('Y') + 5 }}" class="form-control">
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">YouTube URL</label>
                    <input type="url" name="youtube_url" value="{{ old('youtube_url', 'https://www.youtube.com/watch?v='.$movie->youtube_id) }}" required class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                    @error('youtube_url') <p class="nf-error" style="color: var(--danger); font-size: 0.75rem; margin-top: 0.4rem;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Status</label>
                    <select name="status" class="form-control">
                        <option value="pending" {{ old('status', $movie->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('status', $movie->status) === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ old('status', $movie->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div x-data="{ 
                    selectedGenres: {{ json_encode(array_map('strval', old('genres', $movie->genres->pluck('id')->toArray()))) }},
                    selectedCasts: {{ json_encode(array_map('strval', old('casts', $movie->castMembers->pluck('id')->toArray()))) }}
                }">
                    <div style="margin-bottom: 2rem; border-top: 1px solid var(--border-color); padding-top: 2rem;">
                        <label style="display: block; margin-bottom: 1.25rem; font-weight: 700; font-size: 1rem;">Genres</label>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                            @foreach($genres as $genre)
                                <label style="cursor: pointer; display: flex; align-items: center; gap: 0.5rem; background: #fff; padding: 0.4rem 1rem; border-radius: 9999px; border: 2px solid var(--border-color); transition: all 0.2s;" :style="selectedGenres.includes('{{ $genre->id }}') ? 'border-color: var(--primary); background: #eff6ff' : ''">
                                    <input type="checkbox" name="genres[]" value="{{ $genre->id }}" x-model="selectedGenres" style="width: 1rem; height: 1rem; accent-color: var(--primary);">
                                    <span style="font-size: 0.875rem; font-weight: 500;">{{ $genre->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div style="margin-bottom: 2rem; border-top: 1px solid var(--border-color); padding-top: 2rem;">
                        <label style="display: block; margin-bottom: 1.25rem; font-weight: 700; font-size: 1rem;">Cast Members</label>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: 1rem; max-height: 400px; overflow-y: auto; padding: 1.5rem; background: #f8fafc; border-radius: 0.75rem; border: 1px solid var(--border-color);">
                            @foreach($casts as $cast)
                                <label style="cursor: pointer; position: relative; display: block;">
                                    <div 
                                        :style="selectedCasts.includes('{{ $cast->id }}') ? 'background: #fff; border-color: var(--primary); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1)' : 'background: transparent; border-color: transparent'"
                                        style="text-align: center; padding: 0.75rem; border-radius: 0.75rem; transition: all 0.2s; border: 2px solid transparent;"
                                    >
                                        <div style="position: absolute; top: 5px; right: 5px; z-index: 2;">
                                            <input type="checkbox" name="casts[]" value="{{ $cast->id }}" x-model="selectedCasts" style="width: 1rem; height: 1rem; accent-color: var(--primary);">
                                        </div>

                                        <div style="width: 60px; height: 60px; border-radius: 50%; overflow: hidden; margin: 0 auto 0.5rem; border: 2px solid #fff;">
                                            @if($cast->image)
                                                <img src="{{ $cast->image }}" alt="{{ $cast->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <div style="width: 100%; height: 100%; background: #e2e8f0; color: #475569; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.2rem;">
                                                    {{ strtoupper(substr($cast->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div style="font-size: 0.75rem; font-weight: 600; color: var(--text-main); line-height: 1.2;">{{ $cast->name }}</div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 2rem; border-top: 1px solid var(--border-color); padding-top: 2rem;">
                    <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Description</label>
                    <textarea name="description" rows="5" class="form-control" placeholder="Briefly describe the movie...">{{ old('description', $movie->description) }}</textarea>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2.5rem;">
                    <button type="submit" class="btn btn-primary" style="flex: 2; justify-content: center; height: 3.5rem; font-size: 1rem;">Update Movie Information</button>
                    <a href="{{ route('admin.movies.index') }}" class="btn btn-outline" style="flex: 1; justify-content: center; height: 3.5rem; font-size: 1rem;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
