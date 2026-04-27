<x-layouts.netflix title="Admin Dashboard">
    <header class="nf-header">
        <div style="display: flex; align-items: center; gap: 2rem;">
            <a class="nf-logo" href="{{ route('home') }}">HABESHAFLIX ADMIN</a>
            <nav class="nf-nav">
                <a class="active" href="{{ route('admin.dashboard') }}">Moderation</a>
                <a href="{{ route('admin.movies.index') }}">Movies</a>
                <a href="{{ route('admin.casts.index') }}">Casts</a>
                <a href="{{ route('admin.genres.index') }}">Genres</a>
            </nav>
        </div>
        <a class="nf-btn nf-btn-muted nf-small-btn" href="{{ route('home') }}">Back to Site</a>
    </header>

    <main class="nf-content">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
            <div class="nf-card" style="padding: 1.5rem; text-align: center;">
                <h3 style="color: #b3b3b3; margin: 0; font-size: 0.9rem; text-transform: uppercase;">Pending Approval</h3>
                <p style="font-size: 2.5rem; font-weight: bold; margin: 0.5rem 0;">{{ $pendingMovies->count() }}</p>
            </div>
            <div class="nf-card" style="padding: 1.5rem; text-align: center;">
                <h3 style="color: #b3b3b3; margin: 0; font-size: 0.9rem; text-transform: uppercase;">Total Movies</h3>
                <p style="font-size: 2.5rem; font-weight: bold; margin: 0.5rem 0;">{{ $totalMovies }}</p>
            </div>
            <div class="nf-card" style="padding: 1.5rem; text-align: center;">
                <h3 style="color: #b3b3b3; margin: 0; font-size: 0.9rem; text-transform: uppercase;">Total Users</h3>
                <p style="font-size: 2.5rem; font-weight: bold; margin: 0.5rem 0;">{{ $totalUsers }}</p>
            </div>
        </div>

        @if (session('status'))
            <div style="background: #10b981; color: #fff; padding: 1rem; margin-bottom: 2rem; border-radius: .3rem;">
                {{ session('status') }}
            </div>
        @endif

        <section>
            <h2 style="margin-bottom: 1.5rem;">Pending Movie Submissions</h2>

            @if ($pendingMovies->isEmpty())
                <div class="nf-card" style="padding: 2rem; text-align: center;">
                    <p style="color: #b3b3b3; margin: 0;">No pending submissions at the moment.</p>
                </div>
            @else
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; background: #141414; border: 1px solid #333;">
                        <thead>
                            <tr style="text-align: left; border-bottom: 2px solid #333;">
                                <th style="padding: 1rem;">Movie</th>
                                <th style="padding: 1rem;">Submitted By</th>
                                <th style="padding: 1rem;">Year</th>
                                <th style="padding: 1rem;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingMovies as $movie)
                                <tr style="border-bottom: 1px solid #333;">
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; align-items: center; gap: 1rem;">
                                            <img src="https://img.youtube.com/vi/{{ $movie->youtube_id }}/default.jpg" style="height: 40px; border-radius: 4px;">
                                            <div>
                                                <div style="font-weight: bold;">{{ $movie->title }}</div>
                                                <a href="https://youtube.com/watch?v={{ $movie->youtube_id }}" target="_blank" style="color: #e50914; font-size: 0.8rem;">Watch Preview</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem;">{{ $movie->creator->name }}</td>
                                    <td style="padding: 1rem;">{{ $movie->year ?? 'N/A' }}</td>
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; gap: 0.5rem;">
                                            <form action="{{ route('admin.movies.approve', $movie) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="nf-btn nf-small-btn" style="background: #10b981;">Approve</button>
                                            </form>
                                            <form action="{{ route('admin.movies.reject', $movie) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="nf-btn nf-btn-muted nf-small-btn">Reject</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </main>
</x-layouts.netflix>
