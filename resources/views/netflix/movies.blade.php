<x-layouts.netflix title="HabeshaFlix - Movies">
    <header class="nf-header scrolled">
        <div style="display: flex; align-items: center;">
            <a class="nf-logo" href="{{ route('browse') }}">HABESHAFLIX</a>
            <nav class="nf-nav">
                <a class="{{ request()->routeIs('browse') ? 'active' : '' }}" href="{{ route('browse') }}">Home</a>
                <a class="{{ request()->routeIs('movies') ? 'active' : '' }}" href="{{ route('movies') }}">Movies</a>
                <a class="{{ request()->routeIs('series') ? 'active' : '' }}" href="{{ route('series') }}">Series</a>
                <a class="{{ request()->routeIs('new-popular') ? 'active' : '' }}" href="{{ route('new-popular') }}">New & Popular</a>
                <a class="{{ request()->routeIs('my-list') ? 'active' : '' }}" href="{{ route('my-list') }}">My List</a>
            </nav>
        </div>

        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <form action="{{ route('search') }}" method="GET" class="nf-search-box">
                <div class="nf-search-input-wrapper">
                    <svg class="nf-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" name="q" placeholder="Titles, people, genres" value="{{ request('q') }}" class="nf-search-input">
                </div>
            </form>

            @auth
                <div class="nf-user-menu">
                    <div class="nf-user-trigger">
                        <div class="nf-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        <span class="nf-caret"></span>
                    </div>
                    <div class="nf-dropdown">
                        <div class="nf-dropdown-arrow"></div>
                        <div class="nf-dropdown-inner">
                            <div class="nf-dropdown-user">
                                <div class="nf-avatar nf-avatar-small">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
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

    @if(!$isFiltered)
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
    @endif

    <main class="nf-content" style="{{ $isFiltered ? 'padding-top: 100px;' : '' }}">
        <div class="nf-filter-bar">
            <div class="nf-filter-controls">
                <h1 class="nf-page-title">Movies</h1>
                
                <form action="{{ route('movies') }}" method="GET" class="nf-filter-form">
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                    
                    <select name="genre" onchange="this.form.submit()" class="nf-select">
                        <option value="">Genres</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                        @endforeach
                    </select>

                    <select name="year" onchange="this.form.submit()" class="nf-select">
                        <option value="">Year</option>
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>

                    @if(request('genre') || request('year') || request('sort'))
                        <a href="{{ route('movies') }}" class="nf-clear-link">Clear all</a>
                    @endif
                </form>
            </div>

            <div class="nf-sort-controls">
                <span class="nf-sort-label">Sort by:</span>
                <form action="{{ route('movies') }}" method="GET">
                    @if(request('genre')) <input type="hidden" name="genre" value="{{ request('genre') }}"> @endif
                    @if(request('year')) <input type="hidden" name="year" value="{{ request('year') }}"> @endif
                    <select name="sort" onchange="this.form.submit()" class="nf-select nf-select-minimal">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>A-Z</option>
                        <option value="year" {{ request('sort') == 'year' ? 'selected' : '' }}>Year</option>
                    </select>
                </form>
            </div>
        </div>

        @if($movies->isEmpty())
            <div class="nf-empty-state">
                <p>No movies found matching your criteria.</p>
                <a href="{{ route('movies') }}" class="nf-btn nf-btn-muted">Browse All Movies</a>
            </div>
        @else
            <div class="nf-card-grid">
                @foreach($movies as $movie)
                    @include('netflix.partials.card', ['movie' => $movie])
                @endforeach
            </div>

            <div class="nf-pagination-wrapper">
                {{ $movies->links('pagination::bootstrap-4') }}
            </div>
        @endif

        @if(!$isFiltered && isset($rows) && count($rows) > 0)
            <div style="margin-top: 4rem;">
                @foreach (array_slice($rows, 1) as $row)
                    @include('netflix.partials.row', ['title' => $row['title'], 'items' => $row['items']])
                @endforeach
            </div>
        @endif
    </main>

    <style>
        .nf-pagination-wrapper {
            margin-top: 4rem;
            display: flex;
            justify-content: center;
        }
        .nf-pagination-wrapper .pagination {
            display: flex;
            list-style: none;
            gap: 0.5rem;
        }
        .nf-pagination-wrapper .page-link {
            background: #141414;
            color: #fff;
            border: 1px solid #333;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.2s;
        }
        .nf-pagination-wrapper .page-item.active .page-link {
            background: var(--danger);
            border-color: var(--danger);
        }
        .nf-pagination-wrapper .page-link:hover {
            background: #222;
        }
        .nf-pagination-wrapper .page-item.disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .nf-filter-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1.5rem;
        }
        .nf-filter-controls {
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        .nf-page-title {
            margin: 0;
            font-size: 2.25rem;
            font-weight: 800;
        }
        .nf-filter-form {
            display: flex; gap: 0.75rem; align-items: center;
        }
        .nf-select {
            background: #000; color: #fff; border: 1px solid rgba(255,255,255,0.3); padding: 0.4rem 0.8rem; font-size: 0.85rem; border-radius: 2px; cursor: pointer; outline: none; transition: border-color 0.3s;
        }
        .nf-select:hover { border-color: #fff; }
        .nf-select-minimal { border: none; font-weight: 700; padding-right: 1.5rem; background: transparent; }
        .nf-clear-link { font-size: 0.8rem; color: var(--muted); text-decoration: underline; }
        .nf-sort-controls { display: flex; align-items: center; gap: 0.5rem; }
        .nf-sort-label { font-size: 0.85rem; color: #999; }
        .nf-empty-state { text-align: center; padding: 8rem 0; color: var(--muted); }
        .nf-empty-state p { font-size: 1.25rem; margin-bottom: 1.5rem; }
        
        /* Copied from library-page for consistency */
        .nf-search-box { position: relative; }
        .nf-search-input-wrapper { position: relative; display: flex; align-items: center; }
        .nf-search-icon { position: absolute; left: 10px; width: 1.25rem; height: 1.25rem; color: #fff; pointer-events: none; }
        .nf-search-input { background: rgba(0,0,0,0.75); border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 0.5rem 0.5rem 0.5rem 2.5rem; font-size: 0.85rem; width: 35px; transition: width 0.4s var(--ease-out), border-color 0.3s; cursor: pointer; border-radius: 2px; }
        .nf-search-input:focus { width: 250px; outline: none; border-color: #fff; cursor: text; background: #000; }
        .nf-user-menu { position: relative; }
        .nf-user-trigger { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; }
        .nf-avatar { width: 32px; height: 32px; background: var(--danger); border-radius: 4px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem; color: #fff; }
        .nf-avatar-small { width: 24px; height: 24px; font-size: 0.75rem; }
        .nf-caret { width: 0; height: 0; border-left: 5px solid transparent; border-right: 5px solid transparent; border-top: 5px solid #fff; transition: transform 0.3s; }
        .nf-user-menu:hover .nf-caret { transform: rotate(180deg); }
        .nf-dropdown { position: absolute; top: 100%; right: 0; padding-top: 15px; opacity: 0; visibility: hidden; transition: all 0.2s; width: 200px; z-index: 1000; }
        .nf-user-menu:hover .nf-dropdown { opacity: 1; visibility: visible; }
        .nf-dropdown-arrow { position: absolute; top: 10px; right: 10px; border-left: 7px solid transparent; border-right: 7px solid transparent; border-bottom: 7px solid #fff; }
        .nf-dropdown-inner { background: rgba(0,0,0,0.9); border: 1px solid rgba(255,255,255,0.15); padding: 10px 0; }
        .nf-dropdown-inner a, .nf-dropdown-inner button { display: block; width: 100%; padding: 10px 15px; font-size: 0.8rem; color: #fff; text-align: left; background: transparent; border: none; cursor: pointer; }
        .nf-dropdown-inner a:hover, .nf-dropdown-inner button:hover { text-decoration: underline; }
        .nf-dropdown-user { display: flex; align-items: center; gap: 10px; padding: 5px 15px 10px; font-size: 0.85rem; font-weight: 600; }
        .nf-dropdown-divider { height: 1px; background: rgba(255,255,255,0.1); margin: 5px 0; }
    </style>
</x-layouts.netflix>
