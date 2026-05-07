<x-layouts.admin title="Manage Genres">
    <div class="admin-header">
        <div class="header-title">
            <h1>Genre Management</h1>
            <p>View and organize movie genres available in the system.</p>
        </div>
    </div>

    <div class="admin-card">
        <div class="card-header">
            <h2>System Genres</h2>
            <span class="badge badge-info">{{ $genres->count() }} Total</span>
        </div>
        <div style="padding: 2rem;">
            <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 0.9375rem;">
                The following genres are used to categorize movies and series across the platform.
            </p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1.25rem;">
                @foreach($genres as $genre)
                    <div style="background: #f8fafc; padding: 1.25rem; border-radius: 0.75rem; text-align: center; border: 1px solid var(--border-color); font-weight: 600; color: var(--text-main); transition: all 0.2s; cursor: default;" onmouseover="this.style.background='#fff'; this.style.borderColor='var(--primary)'; this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.1)'" onmouseout="this.style.background='#f8fafc'; this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'">
                        {{ $genre->name }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="admin-card" style="margin-top: 2rem; background: #f1f5f9; border-style: dashed;">
        <div style="padding: 2rem; text-align: center;">
            <svg style="width: 3rem; height: 3rem; color: var(--text-muted); margin-bottom: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <h3 style="margin: 0; color: var(--text-main);">Custom Genres</h3>
            <p style="color: var(--text-muted); margin-top: 0.5rem;">New genres can be added via the database seeder or migrations.</p>
        </div>
    </div>
</x-layouts.admin>
