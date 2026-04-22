<header class="nf-header">
    <a class="nf-logo" href="{{ route('browse') }}">HABESHAFLIX</a>
    <nav class="nf-nav">
        <a class="{{ request()->routeIs('browse') ? 'active' : '' }}" href="{{ route('browse') }}">Home</a>
        <a class="{{ request()->routeIs('movies') ? 'active' : '' }}" href="{{ route('movies') }}">Movies</a>
        <a class="{{ request()->routeIs('series') ? 'active' : '' }}" href="{{ route('series') }}">Series</a>
        <a class="{{ request()->routeIs('new-popular') ? 'active' : '' }}" href="{{ route('new-popular') }}">New & Popular</a>
        <a class="{{ request()->routeIs('my-list') ? 'active' : '' }}" href="{{ route('my-list') }}">My List</a>
    </nav>
    <a class="nf-btn nf-btn-muted nf-small-btn" href="{{ route('profiles') }}">Switch Profile</a>
</header>

<section class="nf-hero" style="background-image:linear-gradient(to top, #0b0b0b 15%, rgba(11,11,11,0.4)), url('{{ $hero['backdrop'] }}');">
    <div class="nf-hero-content">
        <p class="nf-kicker">{{ $page }}</p>
        <h1>{{ $hero['title'] }}</h1>
        <p>{{ $hero['description'] }}</p>
        <div class="nf-actions">
            <a class="nf-btn nf-btn-light" href="{{ route('watch') }}">Play</a>
            <a class="nf-btn nf-btn-muted" href="{{ route('new-popular') }}">More Info</a>
        </div>
    </div>
</section>

<main class="nf-content">
    @foreach ($rows as $row)
        @include('netflix.partials.row', ['title' => $row['title'], 'items' => $row['items']])
    @endforeach
</main>
