<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'HabeshaFlix' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root {
            --bg: #080808;
            --panel: #121212;
            --text: #ffffff;
            --muted: #a3a3a3;
            --danger: #e50914;
            --danger-hover: #f40612;
            --header-height: 70px;
            --ease-out: cubic-bezier(0.33, 1, 0.68, 1);
        }

        * {
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body.nf-body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Be Vietnam Pro', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            overflow-x: hidden;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg);
        }
        ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #444;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: all 0.2s var(--ease-out);
        }

        .nf-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: var(--header-height);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 4%;
            background: linear-gradient(to bottom, rgba(0,0,0,0.8) 0%, transparent 100%);
            transition: background-color 0.4s var(--ease-out);
        }

        .nf-header.scrolled {
            background-color: var(--bg);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .nf-header-landing {
            background: transparent;
            border-bottom: none;
        }

        .nf-logo {
            color: var(--danger);
            font-weight: 800;
            letter-spacing: -0.02em;
            font-size: 1.75rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .nf-logo:hover {
            color: var(--danger-hover);
            transform: scale(1.02);
        }

        .nf-nav {
            display: flex;
            gap: 1.5rem;
            margin-left: 2rem;
            flex-grow: 1;
        }

        .nf-nav a {
            color: #e5e5e5;
            font-size: 0.875rem;
            font-weight: 400;
        }

        .nf-nav a:hover,
        .nf-nav a.active {
            color: #fff;
            font-weight: 600;
        }

        .nf-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 4px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            gap: 0.5rem;
            transition: all 0.2s var(--ease-out);
        }

        .nf-btn:active {
            transform: scale(0.98);
        }

        .nf-small-btn {
            font-size: 0.85rem;
            padding: 0.4rem 1rem;
        }

        .nf-btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .nf-btn-danger:hover {
            background: var(--danger-hover);
            box-shadow: 0 4px 12px rgba(229, 9, 20, 0.3);
        }

        .nf-btn-muted {
            background: rgba(109, 109, 110, 0.5);
            color: #fff;
            backdrop-filter: blur(4px);
        }

        .nf-btn-muted:hover {
            background: rgba(109, 109, 110, 0.8);
        }

        .nf-btn-light {
            background: #fff;
            color: #000;
        }

        .nf-btn-light:hover {
            background: rgba(255, 255, 255, 0.8);
        }

        /* Hero Center (Landing) */
        .nf-hero-center {
            max-width: 800px;
            margin: 25vh auto 0;
            text-align: center;
            padding: 0 1.5rem;
            animation: slideUp 0.8s var(--ease-out);
        }

        .nf-hero-center h1 {
            font-size: clamp(2.5rem, 8vw, 4.5rem);
            font-weight: 800;
            margin: 0 0 1rem;
            line-height: 1.1;
        }

        .nf-hero-center p {
            font-size: clamp(1.1rem, 3vw, 1.5rem);
            margin-bottom: 2rem;
            color: #fff;
        }

        /* Hero (Browse) */
        .nf-hero {
            position: relative;
            height: 85vh;
            background-size: cover;
            background-position: center 20%;
            display: flex;
            align-items: center;
            padding: 0 4%;
            margin-bottom: -100px;
        }

        .nf-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 60%),
                        linear-gradient(to top, var(--bg) 0%, transparent 30%);
            pointer-events: none;
        }

        .nf-hero-content {
            position: relative;
            z-index: 10;
            max-width: 600px;
            animation: fadeIn 1s var(--ease-out);
        }

        .nf-kicker {
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            font-size: 0.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .nf-hero h1 {
            margin: 0.5rem 0 1rem;
            font-size: clamp(2.5rem, 6vw, 4rem);
            font-weight: 800;
            line-height: 1.1;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
        }

        .nf-hero p {
            font-size: 1.1rem;
            line-height: 1.4;
            color: #fff;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.5);
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        /* Content */
        .nf-content {
            position: relative;
            z-index: 20;
            padding: 0 4% 4rem;
        }

        .nf-row {
            margin-bottom: 3rem;
        }

        .nf-row-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 1rem;
        }

        .nf-row-header h2 {
            margin: 0;
            font-size: 1.4rem;
            font-weight: 600;
            color: #e5e5e5;
            transition: color 0.3s;
        }

        .nf-row:hover .nf-row-header h2 {
            color: #fff;
        }

        /* Cards */
        .nf-card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem 0.75rem;
        }

        .nf-card {
            position: relative;
            border-radius: 4px;
            overflow: hidden;
            background: #181818;
            transition: transform 0.3s var(--ease-out), z-index 0s 0.3s;
            cursor: pointer;
        }

        .nf-card:hover {
            transform: scale(1.15);
            z-index: 100;
            box-shadow: 0 12px 30px rgba(0,0,0,0.6);
            transition: transform 0.4s var(--ease-out);
        }

        .nf-card img {
            width: 100%;
            aspect-ratio: 16/9;
            object-fit: cover;
            display: block;
        }

        .nf-card-body {
            padding: 1rem;
            opacity: 0;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,1) 0%, rgba(0,0,0,0.7) 100%);
            transition: opacity 0.3s;
        }

        .nf-card:hover .nf-card-body {
            opacity: 1;
        }

        .nf-card-body h3 {
            margin: 0 0 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Forms */
        .nf-signin {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://assets.nflxext.com/ffe/siteui/vlv3/f841d4c7-10e1-40af-bca1-0744f902144f/af6a5367-e9a0-4354-9a4d-f4a4347716ed/ET-en-20220502-popsignuptwoweeks-perspective_alpha_website_large.jpg');
            background-size: cover;
        }

        .nf-form {
            width: 100%;
            max-width: 450px;
            background: rgba(0,0,0,0.75);
            padding: 60px 68px 40px;
            border-radius: 4px;
        }

        .nf-form h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .nf-form input {
            width: 100%;
            height: 50px;
            background: #333;
            border: none;
            border-radius: 4px;
            color: #fff;
            padding: 0 20px;
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .nf-form input:focus {
            background: #454545;
            outline: none;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 1100px) {
            .nf-nav { display: none; }
            .nf-header { padding: 0 2%; }
        }

        @media (max-width: 600px) {
            .nf-form { padding: 40px 30px; }
            .nf-hero { height: 60vh; }
            .nf-hero-content h1 { font-size: 2rem; }
        }
    </style>
</head>
<body class="nf-body">
    {{ $slot }}

    <script>
        window.addEventListener('scroll', () => {
            const header = document.querySelector('.nf-header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
