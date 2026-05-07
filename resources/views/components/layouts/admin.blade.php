<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin' }} - HabeshaFlix</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root {
            --admin-bg: #f8fafc;
            --sidebar-bg: #0f172a;
            --sidebar-text: #94a3b8;
            --sidebar-active: #ffffff;
            --sidebar-accent: #38bdf8;
            --card-bg: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
        }

        * {
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--admin-bg);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 1.5rem;
            font-size: 1.25rem;
            font-weight: 800;
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-brand span {
            color: var(--sidebar-accent);
        }

        .sidebar-nav {
            padding: 1.5rem 1rem;
            flex-grow: 1;
        }

        .nav-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            color: #475569;
            margin-bottom: 0.75rem;
            display: block;
            padding-left: 0.5rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
            transition: all 0.2s;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.05);
            color: #fff;
        }

        .nav-item.active {
            background: var(--primary);
            color: #fff;
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        /* Main Content */
        .admin-main {
            flex-grow: 1;
            margin-left: 260px;
            padding: 2rem;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header-title h1 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .header-title p {
            margin: 0.25rem 0 0;
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: var(--card-bg);
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid var(--border-color);
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .stat-value {
            font-size: 1.875rem;
            font-weight: 700;
            margin-top: 0.5rem;
            display: block;
        }

        /* Tables */
        .admin-card {
            background: var(--card-bg);
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h2 {
            margin: 0;
            font-size: 1.125rem;
            font-weight: 600;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th {
            text-align: left;
            padding: 0.75rem 1.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            background: #f1f5f9;
            font-weight: 700;
        }

        .admin-table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9rem;
        }

        .admin-table tr:last-child td {
            border-bottom: none;
        }

        .admin-table tr:hover {
            background-color: #f8fafc;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success { background: #dcfce7; color: #166534; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-info { background: #e0f2fe; color: #075985; }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid transparent;
            text-decoration: none;
        }

        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-hover); }

        .btn-outline { background: #fff; border-color: var(--border-color); color: var(--text-main); }
        .btn-outline:hover { background: #f8fafc; border-color: #cbd5e1; }

        .btn-danger { background: var(--danger); color: #fff; }
        .btn-danger:hover { opacity: 0.9; }

        .btn-sm { padding: 0.375rem 0.75rem; font-size: 0.75rem; }

        /* Form Controls */
        .form-control {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 0.9375rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 0.9375rem;
            font-weight: 500;
        }

        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }

        @media (max-width: 1024px) {
            .admin-sidebar { width: 80px; }
            .sidebar-brand span, .nav-item span, .nav-label, .sidebar-footer { display: none; }
            .admin-main { margin-left: 80px; }
            .nav-item { justify-content: center; padding: 1rem; }
        }
    </style>
</head>
<body>
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <svg style="width: 1.5rem; height: 1.5rem; color: var(--primary);" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/><path d="M12 6c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"/></svg>
            <span>HABESHA<span>FLIX</span></span>
        </div>
        
        <nav class="sidebar-nav">
            <span class="nav-label">Main Menu</span>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a11 11 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Dashboard</span>
            </a>
            
            <span class="nav-label" style="margin-top: 1.5rem;">Management</span>
            <a href="{{ route('admin.movies.index') }}" class="nav-item {{ request()->routeIs('admin.movies.*') ? 'active' : '' }}">
                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
                <span>Movies</span>
            </a>
            <a href="{{ route('admin.casts.index') }}" class="nav-item {{ request()->routeIs('admin.casts.*') ? 'active' : '' }}">
                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span>Casts</span>
            </a>
            <a href="{{ route('admin.genres.index') }}" class="nav-item {{ request()->routeIs('admin.genres.*') ? 'active' : '' }}">
                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M17 7h.01M17 11h.01M17 15h.01M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                <span>Genres</span>
            </a>
        </nav>
        
        <div class="sidebar-footer">
            <a href="{{ route('home') }}" class="nav-item">
                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Back to Site</span>
            </a>
        </div>
    </aside>

    <main class="admin-main">
        {{ $slot }}
    </main>
</body>
</html>
