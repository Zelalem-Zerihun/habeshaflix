<x-layouts.netflix title="Manage Casts">
    <header class="nf-header">
        <div style="display: flex; align-items: center; gap: 2rem;">
            <a class="nf-logo" href="{{ route('home') }}">HABESHAFLIX ADMIN</a>
            <nav class="nf-nav">
                <a href="{{ route('admin.dashboard') }}">Moderation</a>
                <a href="{{ route('admin.movies.index') }}">Movies</a>
                <a class="active" href="{{ route('admin.casts.index') }}">Casts</a>
                <a href="{{ route('admin.genres.index') }}">Genres</a>
            </nav>
        </div>
        <a class="nf-btn nf-btn-muted nf-small-btn" href="{{ route('home') }}">Back to Site</a>
    </header>

    <main class="nf-content">
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 3rem;">
            <div>
                <h2 style="margin-bottom: 1.5rem;">Add New Cast</h2>
                <div class="nf-card" style="padding: 1.5rem;">
                    <form action="{{ route('admin.casts.store') }}" method="POST" enctype="multipart/form-data" style="display: grid; gap: 1rem;">
                        @csrf
                        <div>
                            <label style="display: block; margin-bottom: .5rem;">Name</label>
                            <input type="text" name="name" required style="width: 100%; padding: .75rem; background: #333; border: 1px solid #444; color: #fff; border-radius: 4px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: .5rem;">Picture</label>
                            <input type="file" name="image" accept="image/*" style="width: 100%; padding: .75rem; background: #333; border: 1px solid #444; color: #fff; border-radius: 4px;">
                        </div>
                        <button type="submit" class="nf-btn" style="width: 100%;">Add Cast Member</button>
                    </form>
                </div>
            </div>

            <div>
                <h2 style="margin-bottom: 1.5rem;">Cast Members</h2>
                @if($casts->isEmpty())
                    <p style="color: #b3b3b3;">No cast members found.</p>
                @else
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1.5rem;">
                        @foreach($casts as $cast)
                            <div class="nf-card" style="padding: 1rem; text-align: center;">
                                @if($cast->image)
                                    <img src="{{ $cast->image }}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: .5rem; border: 2px solid #333;">
                                @else
                                    <div style="width: 80px; height: 80px; border-radius: 50%; background: #333; margin: 0 auto .5rem; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.5rem;">
                                        {{ strtoupper(substr($cast->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div style="font-weight: bold;">{{ $cast->name }}</div>
                            </div>
                        @endforeach
                    </div>
                    <div style="margin-top: 2rem;">
                        {{ $casts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>
</x-layouts.netflix>
