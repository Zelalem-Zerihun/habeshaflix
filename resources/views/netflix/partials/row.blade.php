<section class="nf-row">
    <div class="nf-row-header">
        <h2>{{ $title }}</h2>
        <a href="{{ route('watch', ['slug' => \Illuminate\Support\Str::slug($title)]) }}">Play All</a>
    </div>
    <div class="nf-card-grid">
        @foreach ($items as $item)
            <article class="nf-card">
                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }} poster">
                <div class="nf-card-body">
                    <h3>{{ $item['title'] }}</h3>
                    <a class="nf-link-btn" href="{{ route('watch', ['slug' => \Illuminate\Support\Str::slug($item['title'])]) }}">Watch</a>
                </div>
            </article>
        @endforeach
    </div>
</section>
