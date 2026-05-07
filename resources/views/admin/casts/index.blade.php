<x-layouts.admin title="Manage Casts">
    <div class="admin-header">
        <div class="header-title">
            <h1>Cast Management</h1>
            <p>Add and manage actors and crew members.</p>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
        <div>
            <div class="admin-card">
                <div class="card-header">
                    <h2>Add New Cast</h2>
                </div>
                <div style="padding: 1.5rem;">
                    <form action="{{ route('admin.casts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div style="margin-bottom: 1.25rem;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.875rem;">Full Name</label>
                            <input type="text" name="name" required class="form-control" placeholder="e.g. Leonardo DiCaprio">
                        </div>
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.875rem;">Profile Picture</label>
                            <input type="file" name="image" accept="image/*" class="form-control" style="padding: 0.5rem;">
                            <p style="margin-top: 0.4rem; font-size: 0.75rem; color: var(--text-muted);">Recommended: Square image, 400x400px</p>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Add Cast Member</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <div class="card-header">
                <h2>Cast Directory</h2>
                <div style="font-size: 0.875rem; color: var(--text-muted);">
                    {{ $casts->total() }} Members
                </div>
            </div>
            
            @if($casts->isEmpty())
                <div style="padding: 3rem; text-align: center; color: var(--text-muted);">
                    <p>No cast members found.</p>
                </div>
            @else
                <div style="padding: 1.5rem;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 1.5rem;">
                        @foreach($casts as $cast)
                            <div style="text-align: center; background: #f8fafc; padding: 1rem; border-radius: 0.75rem; border: 1px solid var(--border-color); transition: all 0.2s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border-color)'">
                                <div style="width: 80px; height: 80px; margin: 0 auto 0.75rem; border-radius: 50%; overflow: hidden; border: 2px solid #fff; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                                    @if($cast->image)
                                        <img src="{{ $cast->image }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <div style="width: 100%; height: 100%; background: #e2e8f0; color: #475569; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.5rem;">
                                            {{ strtoupper(substr($cast->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div style="font-weight: 600; font-size: 0.875rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $cast->name }}">
                                    {{ $cast->name }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div style="padding: 0 1.5rem 1.5rem;">
                    {{ $casts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
