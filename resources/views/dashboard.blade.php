<x-layouts.netflix title="Dashboard">
    <header class="nf-header">
        <a class="nf-logo" href="{{ route('home') }}">HABESHAFLIX</a>
        <nav class="nf-nav">
            <a href="{{ route('home') }}">Home</a>
            <a class="active" href="{{ route('dashboard') }}">My Dashboard</a>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" style="color: #e50914; font-weight: bold;">Admin Panel</a>
            @endif
        </nav>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <span style="color: #b3b3b3;">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nf-btn nf-btn-muted nf-small-btn">Sign Out</button>
            </form>
        </div>
    </header>

    <main class="nf-content" style="padding-top: 2rem;">
        <section style="margin-bottom: 3rem;">
            <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem;">Welcome back, {{ auth()->user()->name }}!</h1>
            <p style="color: #b3b3b3; font-size: 1.1rem;">Manage your account and track your submissions.</p>
        </section>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <!-- User Stats / Actions -->
            <div class="nf-card" style="padding: 2rem; display: flex; flex-direction: column; gap: 1.5rem;">
                <h2 style="margin: 0; font-size: 1.5rem;">Quick Actions</h2>
                <div style="display: grid; gap: 1rem;">
                    <a href="{{ route('movies.create') }}" class="nf-btn" style="text-align: center; text-decoration: none;">Submit New Movie</a>
                    <a href="{{ route('profile.edit') }}" class="nf-btn nf-btn-muted" style="text-align: center; text-decoration: none;">Account Settings</a>
                </div>
            </div>

            @if(auth()->user()->isAdmin())
            <div class="nf-card" style="padding: 2rem; border-left: 4px solid #e50914;">
                <h2 style="margin: 0 0 1rem 0; font-size: 1.5rem;">Admin Overview</h2>
                <p style="color: #b3b3b3; margin-bottom: 1.5rem;">There are pending movies awaiting your review.</p>
                <a href="{{ route('admin.dashboard') }}" class="nf-link-btn">Go to Admin Panel →</a>
            </div>
            @endif
        </div>

        <!-- My Submissions -->
        <section style="margin-top: 4rem;">
            <h2 style="margin-bottom: 1.5rem;">My Recent Submissions</h2>
            @php
                $myMovies = auth()->user()->submittedMovies()->latest()->take(5)->get();
            @endphp

            @if($myMovies->isEmpty())
                <div class="nf-card" style="padding: 3rem; text-align: center; background: #181818;">
                    <p style="color: #b3b3b3; margin-bottom: 1.5rem;">You haven't submitted any movies yet.</p>
                    <a href="{{ route('movies.create') }}" style="color: #e50914; font-weight: bold; text-decoration: none;">Submit your first movie!</a>
                </div>
            @else
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem;">
                    @foreach($myMovies as $movie)
                        <div class="nf-card" style="overflow: hidden;">
                            <img src="https://img.youtube.com/vi/{{ $movie->youtube_id }}/mqdefault.jpg" style="width: 100%; aspect-ratio: 16/9; object-fit: cover;">
                            <div style="padding: 1rem;">
                                <h3 style="margin: 0 0 0.5rem 0; font-size: 1.1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $movie->title }}</h3>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 0.85rem; padding: 0.2rem 0.6rem; border-radius: 1rem; 
                                        {{ $movie->status === 'approved' ? 'background: #052e16; color: #4ade80;' : 
                                           ($movie->status === 'rejected' ? 'background: #450a0a; color: #f87171;' : 'background: #1e1b4b; color: #818cf8;') }}">
                                        {{ ucfirst($movie->status) }}
                                    </span>
                                    <a href="{{ route('movies.show', $movie) }}" style="color: #fff; font-size: 0.85rem;">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
</x-layouts.netflix>
