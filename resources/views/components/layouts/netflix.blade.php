<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'HabeshaFlix' }}</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root {
            --bg: #0b0b0b;
            --panel: #141414;
            --text: #f5f5f5;
            --muted: #b3b3b3;
            --danger: #e50914;
        }

        * {
            box-sizing: border-box;
        }

        body.nf-body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Inter, Arial, sans-serif;
            background: radial-gradient(circle at top, #222 0%, var(--bg) 45%);
            color: var(--text);
            padding-top: 80px; /* Space for fixed header */
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .nf-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 3rem;
            backdrop-filter: blur(12px);
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.5));
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nf-header-landing {
            position: absolute;
            max-width: 1200px;
            margin: 0 auto;
            background: transparent;
            border-bottom: none;
            backdrop-filter: none;
            left: 50%;
            transform: translateX(-50%);
        }

        .nf-logo {
            color: var(--danger);
            font-weight: 800;
            letter-spacing: .08rem;
            font-size: 1.85rem;
        }

        .nf-nav {
            display: flex;
            gap: 1.2rem;
            font-size: .95rem;
        }

        .nf-nav a {
            color: #d4d4d4;
            transition: color .2s ease;
        }

        .nf-nav a:hover,
        .nf-nav a.active {
            color: #fff;
            font-weight: 600;
        }

        .nf-btn {
            border: 0;
            border-radius: 4px;
            padding: .65rem 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform .15s ease, opacity .15s ease;
        }

        .nf-btn:hover {
            transform: translateY(-1px);
            opacity: .95;
        }

        .nf-small-btn {
            font-size: .85rem;
        }

        .nf-btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .nf-btn-muted {
            background: rgba(109, 109, 110, .7);
            color: #fff;
        }

        .nf-btn-light {
            background: #fff;
            color: #111;
        }

        .nf-hero-center {
            max-width: 760px;
            margin: 12vh auto 0;
            text-align: center;
            padding: 1rem;
        }

        .nf-hero-center h1 {
            font-size: clamp(2rem, 6vw, 4rem);
            margin: 0 0 .75rem;
            text-wrap: balance;
        }

        .nf-hero-center p {
            color: var(--muted);
            font-size: 1.15rem;
        }

        .nf-actions {
            display: flex;
            justify-content: center;
            gap: .8rem;
            flex-wrap: wrap;
            margin-top: 1.5rem;
        }

        .nf-profiles {
            max-width: 1000px;
            margin: 3rem auto;
            text-align: center;
            padding: 0 1rem;
        }

        .nf-profile-grid {
            margin: 2.5rem 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1.2rem;
        }

        .nf-profile img {
            width: 100%;
            border-radius: .35rem;
            border: 2px solid transparent;
            transition: transform .2s ease, border-color .2s ease;
        }

        .nf-profile:hover img {
            border-color: #fff;
            transform: scale(1.03);
        }

        .nf-profile span {
            color: #c0c0c0;
            margin-top: .5rem;
            display: block;
        }

        .nf-hero {
            min-height: 62vh;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: flex-end;
            padding: 3rem;
        }

        .nf-hero-content {
            max-width: 680px;
            animation: fade-in .5s ease;
        }

        .nf-kicker {
            color: #d4d4d4;
            text-transform: uppercase;
            letter-spacing: .08rem;
            font-size: .8rem;
        }

        .nf-hero h1 {
            margin: .3rem 0;
            font-size: clamp(2rem, 5vw, 4rem);
            text-wrap: balance;
        }

        .nf-hero p {
            color: #ececec;
            line-height: 1.5;
        }

        .nf-content {
            padding: 0 3rem 3rem;
        }

        .nf-row {
            margin-top: 2rem;
        }

        .nf-row-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nf-row-header h2 {
            margin: 0;
            font-size: 1.25rem;
        }

        .nf-row-header a {
            color: #d1d5db;
            font-size: .9rem;
        }

        .nf-card-grid {
            margin-top: .9rem;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: .9rem;
        }

        .nf-card {
            background: var(--panel);
            border-radius: .45rem;
            overflow: hidden;
            border: 1px solid #222;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .nf-card:hover {
            transform: scale(1.03) translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .4);
        }

        .nf-card img {
            width: 100%;
            display: block;
        }

        .nf-card-body {
            padding: .7rem;
        }

        .nf-card-body h3 {
            margin: 0 0 .6rem;
            font-size: .95rem;
        }

        .nf-link-btn {
            display: inline-block;
            padding: .35rem .6rem;
            border-radius: .3rem;
            background: #272727;
            font-size: .85rem;
        }

        .nf-watch {
            max-width: 980px;
            margin: 2rem auto;
            padding: 1rem;
        }

        .nf-watch img {
            width: 100%;
            border-radius: .6rem;
            border: 1px solid #2a2a2a;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .35);
        }

        .nf-signin {
            min-height: calc(100vh - 100px);
            display: grid;
            place-items: center;
            padding: 1rem;
        }

        .nf-form {
            width: min(420px, 100%);
            background: rgba(0, 0, 0, .75);
            border-radius: .5rem;
            padding: 2rem;
        }

        .nf-form h1 {
            margin-top: 0;
        }

        .nf-form label {
            display: block;
            margin-bottom: 1rem;
        }

        .nf-form span {
            display: block;
            margin-bottom: .4rem;
            color: var(--muted);
        }

        .nf-form input {
            width: 100%;
            border: 1px solid #333;
            background: #111;
            color: #fff;
            border-radius: .35rem;
            padding: .75rem;
        }

        .nf-form p {
            color: var(--muted);
            margin-top: 1.2rem;
        }

        @media (max-width: 900px) {
            .nf-header,
            .nf-content,
            .nf-hero {
                padding-inline: 1rem;
            }

            .nf-header {
                flex-wrap: wrap;
            }

            .nf-nav {
                width: 100%;
                overflow-x: auto;
                white-space: nowrap;
                padding-bottom: .2rem;
            }
        }

        @keyframes fade-in {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="nf-body">
    {{ $slot }}
</body>
</html>
