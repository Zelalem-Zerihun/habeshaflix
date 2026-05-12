<x-layouts.admin title="Manage Genres">
    <div class="admin-header">
        <div class="header-title">
            <h1>Genre Management</h1>
            <p>View and organize movie genres available in the system.</p>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 1.25rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem; align-items: start;">
        <div class="admin-card">
            <div class="card-header">
                <h2>System Genres</h2>
                <span class="badge badge-info">{{ $genres->count() }} Total</span>
            </div>
            <div style="padding: 1.5rem;">
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                    @foreach($genres as $genre)
                        <div style="background: #fff; padding: 1rem; border-radius: 0.75rem; border: 1px solid var(--border-color); display: flex; flex-direction: column; gap: 0.75rem; transition: all 0.2s;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                <div style="font-weight: 700; color: var(--text-main);">{{ $genre->name }}</div>
                                <span style="font-size: 0.7rem; background: #f1f5f9; color: #64748b; padding: 0.1rem 0.5rem; border-radius: 9999px; font-weight: 600;">{{ $genre->movies_count }} movies</span>
                            </div>
                            
                            <div style="display: flex; justify-content: flex-end; margin-top: auto;">
                                <form action="{{ route('admin.genres.destroy', $genre) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this genre?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="color: var(--danger); padding: 0.25rem; background: transparent; border: none; cursor: pointer;" title="Delete Genre" {{ $genre->movies_count > 0 ? 'disabled style=opacity:0.3;cursor:not-allowed' : '' }}>
                                        <svg style="width: 1.1rem; height: 1.1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="admin-card">
            <div class="card-header">
                <h2>Add New Genre</h2>
            </div>
            <div style="padding: 1.5rem;">
                <form action="{{ route('admin.genres.store') }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 1.5rem;">
                        <label for="name" style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Genre Name</label>
                        <input type="text" name="name" id="name" class="form-input" placeholder="e.g. Action, Comedy" required>
                        <p style="margin-top: 0.5rem; font-size: 0.75rem; color: var(--text-muted);">Name must be unique and descriptive.</p>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">Create Genre</button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>
