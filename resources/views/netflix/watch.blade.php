<x-layouts.netflix title="Now Watching">
    <header class="nf-header">
        <a class="nf-logo" href="{{ route('browse') }}">HABESHAFLIX</a>
        <a class="nf-btn nf-btn-muted nf-small-btn" href="{{ route('browse') }}">Back to Browse</a>
    </header>

    <main class="nf-watch">
        <h1>Now Playing: {{ ucwords($slug) }}</h1>
        <img src="{{ $poster }}" alt="Now playing placeholder">
        <p>This is a placeholder watch screen. Replace with your real streaming player later.</p>
    </main>
</x-layouts.netflix>
