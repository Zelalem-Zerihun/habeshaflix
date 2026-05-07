<x-layouts.admin title="Dashboard">
    <div class="admin-header">
        <div class="header-title">
            <h1>Moderation Dashboard</h1>
            <p>Overview of system activity and pending approvals.</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.movies.batch') }}" class="btn btn-outline">Batch Upload</a>
            <a href="{{ route('movies.create') }}" class="btn btn-primary">+ Add Movie</a>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-label">Pending Approval</span>
            <span class="stat-value" style="color: var(--warning);">{{ $pendingMovies->count() }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Total Movies</span>
            <span class="stat-value">{{ $totalMovies }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Total Users</span>
            <span class="stat-value">{{ $totalUsers }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Genres</span>
            <span class="stat-value">{{ \App\Models\Genre::count() }}</span>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="admin-card">
        <div class="card-header">
            <h2>Pending Movie Submissions</h2>
            @if(!$pendingMovies->isEmpty())
                <span class="badge badge-warning">{{ $pendingMovies->count() }} Actions Required</span>
            @endif
        </div>
        
        @if ($pendingMovies->isEmpty())
            <div style="padding: 3rem; text-align: center; color: var(--text-muted);">
                <p>No pending submissions at the moment. You're all caught up!</p>
            </div>
        @else
            <div style="overflow-x: auto;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Movie</th>
                            <th>Submitted By</th>
                            <th>Year</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingMovies as $movie)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <img src="https://img.youtube.com/vi/{{ $movie->youtube_id }}/mqdefault.jpg" style="height: 48px; width: 85px; object-fit: cover; border-radius: 0.375rem; border: 1px solid var(--border-color);">
                                        <div>
                                            <div style="font-weight: 600;">{{ $movie->title }}</div>
                                            <a href="https://youtube.com/watch?v={{ $movie->youtube_id }}" target="_blank" style="color: var(--primary); font-size: 0.75rem; font-weight: 500;">Preview Video</a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <div style="width: 24px; height: 24px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700;">
                                            {{ strtoupper(substr($movie->creator->name, 0, 1)) }}
                                        </div>
                                        {{ $movie->creator->name }}
                                    </div>
                                </td>
                                <td><span class="badge badge-info">{{ $movie->year ?? 'N/A' }}</span></td>
                                <td style="text-align: right;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                        <form action="{{ route('admin.movies.approve', $movie) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-primary" style="background: var(--success);">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.movies.reject', $movie) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline">Reject</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layouts.admin>
