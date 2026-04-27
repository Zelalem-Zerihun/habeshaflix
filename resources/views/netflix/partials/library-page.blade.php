<header class="nf-header">
    <a class="nf-logo" href="{{ route('browse') }}">HABESHAFLIX</a>
    <nav class="nf-nav">
        <a class="{{ request()->routeIs('browse') ? 'active' : '' }}" href="{{ route('browse') }}">Home</a>
        <a class="{{ request()->routeIs('movies') ? 'active' : '' }}" href="{{ route('movies') }}">Movies</a>
        <a class="{{ request()->routeIs('series') ? 'active' : '' }}" href="{{ route('series') }}">Series</a>
        <a class="{{ request()->routeIs('new-popular') ? 'active' : '' }}" href="{{ route('new-popular') }}">New & Popular</a>
        <a class="{{ request()->routeIs('my-list') ? 'active' : '' }}" href="{{ route('my-list') }}">My List</a>
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" style="color: #e50914; font-weight: bold;">Admin Panel</a>
            @endif
        @endauth
    </nav>
    <div style="display: flex; align-items: center; gap: 1.5rem;">
        @auth
            <div class="nf-user-dropdown" style="position: relative;">
                <button style="background: transparent; border: none; color: #fff; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; font-weight: 500;">
                    <div style="width: 32px; height: 32px; background: #e50914; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.9rem;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span style="font-size: 0.9rem;">{{ auth()->user()->name }}</span>
                    <span style="font-size: 0.6rem;">▼</span>
                </button>
                <div class="nf-dropdown-content" style="display: none; position: absolute; top: 100%; right: 0; background: rgba(0,0,0,0.9); border: 1px solid #333; min-width: 160px; border-radius: 4px; padding: 0.5rem 0; z-index: 100;">
                    <a href="{{ route('profile.edit') }}" style="display: block; padding: 0.6rem 1rem; font-size: 0.85rem; color: #fff;">Edit Profile</a>
                    <a href="{{ route('dashboard') }}" style="display: block; padding: 0.6rem 1rem; font-size: 0.85rem; color: #fff;">Dashboard</a>
                    <div style="height: 1px; background: #333; margin: 0.4rem 0;"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="width: 100%; text-align: left; background: transparent; border: none; color: #fff; padding: 0.6rem 1rem; font-size: 0.85rem; cursor: pointer;">Sign Out</button>
                    </form>
                </div>
            </div>

            <style>
                .nf-user-dropdown:hover .nf-dropdown-content {
                    display: block !important;
                }
                .nf-dropdown-content a:hover {
                    text-decoration: underline;
                    background: rgba(255,255,255,0.1);
                }
            </style>
        @else
            <a class="nf-btn nf-btn-danger nf-small-btn" href="{{ route('login') }}">Sign In</a>
        @endauth
    </div>
</header>

<section class="nf-hero" style="background-image:linear-gradient(to top, #0b0b0b 15%, rgba(11,11,11,0.4)), url('{{ $hero['backdrop'] }}');">
    <div class="nf-hero-content">
        <p class="nf-kicker">{{ $page }}</p>
        <h1>{{ $hero['title'] }}</h1>
        <p>{{ $hero['description'] }}</p>
        <div class="nf-actions">
            @if(isset($hero['movie']))
                <a class="nf-btn nf-btn-light" href="{{ route('watch', $hero['movie']) }}">Play</a>
            @else
                <a class="nf-btn nf-btn-light" href="#">Play</a>
            @endif
            <a class="nf-btn nf-btn-muted" href="{{ route('new-popular') }}">More Info</a>
        </div>
    </div>
</section>

<main class="nf-content">
    @foreach ($rows as $row)
        @include('netflix.partials.row', ['title' => $row['title'], 'items' => $row['items']])
    @endforeach
</main>
