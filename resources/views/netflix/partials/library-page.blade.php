<header class="nf-header">
    <div style="display: flex; align-items: center;">
        <a class="nf-logo" href="{{ route('browse') }}">HABESHAFLIX</a>
        <nav class="nf-nav">
            <a class="{{ request()->routeIs('browse') ? 'active' : '' }}" href="{{ route('browse') }}">Home</a>
            <a class="{{ request()->routeIs('movies') ? 'active' : '' }}" href="{{ route('movies') }}">Movies</a>
            <a class="{{ request()->routeIs('series') ? 'active' : '' }}" href="{{ route('series') }}">Series</a>
            <a class="{{ request()->routeIs('new-popular') ? 'active' : '' }}" href="{{ route('new-popular') }}">New & Popular</a>
            <a class="{{ request()->routeIs('my-list') ? 'active' : '' }}" href="{{ route('my-list') }}">My List</a>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" style="color: var(--danger); font-weight: 700;">Admin</a>
                @endif
            @endauth
        </nav>
    </div>

    <div style="display: flex; align-items: center; gap: 1.5rem;">
        <form action="{{ route('search') }}" method="GET" class="nf-search-box">
            <div class="nf-search-input-wrapper">
                <svg class="nf-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input 
                    type="text" 
                    name="q" 
                    placeholder="Titles, people, genres" 
                    value="{{ request('q') }}"
                    class="nf-search-input"
                >
            </div>
        </form>

        @auth
            <div class="nf-user-menu">
                <div class="nf-user-trigger">
                    <div class="nf-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="nf-caret"></span>
                </div>
                <div class="nf-dropdown">
                    <div class="nf-dropdown-arrow"></div>
                    <div class="nf-dropdown-inner">
                        <div class="nf-dropdown-user">
                            <div class="nf-avatar nf-avatar-small">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span>{{ auth()->user()->name }}</span>
                        </div>
                        <div class="nf-dropdown-divider"></div>
                        <a href="{{ route('profile.edit') }}">Account</a>
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                        <div class="nf-dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Sign out of HabeshaFlix</button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <a class="nf-btn nf-btn-danger nf-small-btn" href="{{ route('login') }}">Sign In</a>
        @endauth
    </div>
</header>

<section class="nf-hero" style="background-image: url('{{ $hero['backdrop'] }}');">
    <div class="nf-hero-content">
        <p class="nf-kicker">{{ $page }}</p>
        <h1>{{ $hero['title'] }}</h1>
        <p>{{ $hero['description'] }}</p>
        <div class="nf-actions" style="justify-content: flex-start;">
            @if(isset($hero['movie']))
                <a class="nf-btn nf-btn-light" href="{{ route('watch', $hero['movie']) }}">
                    <svg style="width: 1.5rem; height: 1.5rem;" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    Play
                </a>
            @else
                <a class="nf-btn nf-btn-light" href="#">
                    <svg style="width: 1.5rem; height: 1.5rem;" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    Play
                </a>
            @endif
            <a class="nf-btn nf-btn-muted" href="{{ route('new-popular') }}">
                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                More Info
            </a>
        </div>
    </div>
</section>

<main class="nf-content">
    @foreach ($rows as $row)
        @include('netflix.partials.row', ['title' => $row['title'], 'items' => $row['items']])
    @endforeach
</main>

<style>
    .nf-search-box {
        position: relative;
    }
    .nf-search-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .nf-search-icon {
        position: absolute;
        left: 10px;
        width: 1.25rem;
        height: 1.25rem;
        color: #fff;
        pointer-events: none;
    }
    .nf-search-input {
        background: rgba(0,0,0,0.75);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
        padding: 0.5rem 0.5rem 0.5rem 2.5rem;
        font-size: 0.85rem;
        width: 35px;
        transition: width 0.4s var(--ease-out), border-color 0.3s;
        cursor: pointer;
        border-radius: 2px;
    }
    .nf-search-input:focus {
        width: 250px;
        outline: none;
        border-color: #fff;
        cursor: text;
        background: #000;
    }
    
    .nf-user-menu {
        position: relative;
    }
    .nf-user-trigger {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
    .nf-avatar {
        width: 32px;
        height: 32px;
        background: var(--danger);
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        color: #fff;
    }
    .nf-avatar-small {
        width: 24px;
        height: 24px;
        font-size: 0.75rem;
    }
    .nf-caret {
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 5px solid #fff;
        transition: transform 0.3s;
    }
    .nf-user-menu:hover .nf-caret {
        transform: rotate(180deg);
    }
    .nf-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        padding-top: 15px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s;
        width: 200px;
        z-index: 1000;
    }
    .nf-user-menu:hover .nf-dropdown {
        opacity: 1;
        visibility: visible;
    }
    .nf-dropdown-arrow {
        position: absolute;
        top: 10px;
        right: 10px;
        border-left: 7px solid transparent;
        border-right: 7px solid transparent;
        border-bottom: 7px solid #fff;
    }
    .nf-dropdown-inner {
        background: rgba(0,0,0,0.9);
        border: 1px solid rgba(255,255,255,0.15);
        padding: 10px 0;
    }
    .nf-dropdown-inner a, .nf-dropdown-inner button {
        display: block;
        width: 100%;
        padding: 10px 15px;
        font-size: 0.8rem;
        color: #fff;
        text-align: left;
        background: transparent;
        border: none;
        cursor: pointer;
    }
    .nf-dropdown-inner a:hover, .nf-dropdown-inner button:hover {
        text-decoration: underline;
    }
    .nf-dropdown-user {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 5px 15px 10px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .nf-dropdown-divider {
        height: 1px;
        background: rgba(255,255,255,0.1);
        margin: 5px 0;
    }
</style>
