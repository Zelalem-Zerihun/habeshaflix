<x-layouts.netflix title="Admin - Manage Movies">
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

    <main class="nf-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1 style="margin: 0;">Manage All Movies</h1>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('admin.movies.batch') }}" class="nf-btn" style="text-decoration: none; padding: 0.6rem 1.2rem; background: #333;">Batch Upload</a>
                <a href="{{ route('movies.create') }}" class="nf-btn nf-btn-danger" style="text-decoration: none; padding: 0.6rem 1.2rem;">+ Add New Movie</a>
            </div>
        </div>

        @if (session('status'))
            <div style="background: #10b981; color: #fff; padding: 1rem; margin-bottom: 2rem; border-radius: .3rem;">
                {{ session('status') }}
            </div>
        @endif

        <div class="nf-card" style="padding: 0; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse; background: #141414;">
                <thead>
                    <tr style="text-align: left; border-bottom: 2px solid #333; background: #1f1f1f;">
                        <th style="padding: 1rem;">Movie</th>
                        <th style="padding: 1rem;">Submitted By</th>
                        <th style="padding: 1rem;">Status</th>
                        <th style="padding: 1rem;">Date</th>
                        <th style="padding: 1rem; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($movies as $movie)
                        <tr style="border-bottom: 1px solid #333;">
                            <td style="padding: 1rem;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="width: 80px; flex-shrink: 0;">
                                        <img src="https://img.youtube.com/vi/{{ $movie->youtube_id }}/mqdefault.jpg" style="width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: 4px; display: block;">
                                    </div>
                                    <div>
                                        <div style="font-weight: bold;">{{ $movie->title }}</div>
                                        <div style="font-size: 0.8rem; color: #b3b3b3;">{{ $movie->year ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 1rem; color: #b3b3b3;">{{ $movie->creator?->name ?? 'Unknown' }}</td>
                            <td style="padding: 1rem;">
                                <span style="font-size: 0.8rem; padding: 0.2rem 0.6rem; border-radius: 1rem; 
                                    {{ $movie->status === 'approved' ? 'background: #052e16; color: #4ade80;' : 
                                       ($movie->status === 'rejected' ? 'background: #450a0a; color: #f87171;' : 'background: #1e1b4b; color: #818cf8;') }}">
                                    {{ ucfirst($movie->status) }}
                                </span>
                            </td>
                            <td style="padding: 1rem; color: #b3b3b3; font-size: 0.9rem;">{{ $movie->created_at->format('M d, Y') }}</td>
                            <td style="padding: 1rem; text-align: right;">
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end; align-items: center;">
                                    <a href="{{ route('admin.movies.edit', $movie) }}" class="nf-btn nf-small-btn" style="background: #333; color: #fff; padding: 0.4rem 0.8rem; text-decoration: none;">Edit</a>
                                    @if($movie->status !== 'approved')
                                        <form action="{{ route('admin.movies.approve', $movie) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="nf-btn nf-small-btn" style="background: #10b981; padding: 0.4rem 0.8rem;">Approve</button>
                                        </form>
                                    @endif
                                    @if($movie->status !== 'rejected')
                                        <form action="{{ route('admin.movies.reject', $movie) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="nf-btn nf-btn-muted nf-small-btn" style="padding: 0.4rem 0.8rem;">Reject</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this movie?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="nf-btn nf-small-btn" style="background: #e50914; padding: 0.4rem 0.8rem;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 3rem; text-align: center; color: #b3b3b3;">No movies found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 2rem;">
            {{ $movies->links() }}
        </div>
    </main>
</x-layouts.netflix>
