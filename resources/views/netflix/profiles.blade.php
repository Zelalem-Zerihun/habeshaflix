<x-layouts.netflix title="Who is watching?">
    <main class="nf-profiles">
        <a class="nf-logo" href="{{ route('landing') }}">HABESHAFLIX</a>
        <h1>Who is watching?</h1>
        <div class="nf-profile-grid">
            @foreach ($profiles as $profile)
                <a class="nf-profile" href="{{ route('browse') }}">
                    <img src="{{ $profile['image'] }}" alt="{{ $profile['name'] }} profile">
                    <span>{{ $profile['name'] }}</span>
                </a>
            @endforeach
        </div>
        <a class="nf-btn nf-btn-muted" href="{{ route('landing') }}">Back</a>
    </main>
</x-layouts.netflix>
