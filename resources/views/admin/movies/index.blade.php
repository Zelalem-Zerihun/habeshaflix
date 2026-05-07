<x-layouts.admin title="Manage Movies">
    <div class="admin-header">
        <div class="header-title">
            <h1>Manage Movies</h1>
            <p>View, edit, and moderate all movies in the library.</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.movies.batch') }}" class="btn btn-outline">Batch Upload</a>
            <a href="{{ route('movies.create') }}" class="btn btn-primary">+ Add New Movie</a>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="admin-card">
        <div class="card-header">
            <h2>All Movies</h2>
            <div style="font-size: 0.875rem; color: var(--text-muted);">
                Showing {{ $movies->firstItem() ?? 0 }} to {{ $movies->lastItem() ?? 0 }} of {{ $movies->total() }} results
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Movie</th>
                        <th>Submitted By</th>
                        <th>Status</th>
                        <th>Date Added</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($movies as $movie)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="width: 80px; flex-shrink: 0;">
                                        <img src="https://img.youtube.com/vi/{{ $movie->youtube_id }}/mqdefault.jpg" style="width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: 0.375rem; border: 1px solid var(--border-color);">
                                    </div>
                                    <div>
                                        <div style="font-weight: 600;">{{ $movie->title }}</div>
                                        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $movie->year ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <div style="width: 20px; height: 20px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 700;">
                                        {{ strtoupper(substr($movie->creator?->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <span style="font-size: 0.85rem;">{{ $movie->creator?->name ?? 'Unknown' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $movie->status === 'approved' ? 'badge-success' : ($movie->status === 'rejected' ? 'badge-danger' : 'badge-warning') }}">
                                    {{ ucfirst($movie->status) }}
                                </span>
                            </td>
                            <td>
                                <div style="font-size: 0.85rem; color: var(--text-muted);">{{ $movie->created_at->format('M d, Y') }}</div>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: flex; gap: 0.4rem; justify-content: flex-end; align-items: center;">
                                    <a href="{{ route('admin.movies.edit', $movie) }}" class="btn btn-sm btn-outline">Edit</a>
                                    
                                    @if($movie->status !== 'approved')
                                        <form action="{{ route('admin.movies.approve', $movie) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-primary" style="background: var(--success);" title="Approve">
                                                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($movie->status !== 'rejected')
                                        <form action="{{ route('admin.movies.reject', $movie) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline" title="Reject">
                                                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this movie?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 3rem; text-align: center; color: var(--text-muted);">No movies found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $movies->links() }}
    </div>
</x-layouts.admin>
