<x-layouts.netflix title="HabeshaFlix - Unlimited Entertainment">
    <header class="nf-header nf-header-landing">
        <a class="nf-logo" href="{{ route('landing') }}">HABESHAFLIX</a>
        @auth
            <div style="display: flex; gap: 1rem; align-items: center;">
                @if(auth()->user()->isAdmin())
                    <a class="nf-btn nf-btn-muted nf-small-btn" href="{{ route('admin.dashboard') }}">Admin</a>
                @endif
                <a class="nf-btn nf-btn-danger" href="{{ route('browse') }}">Browse</a>
            </div>
        @else
            <a class="nf-btn nf-btn-danger nf-small-btn" href="{{ route('login') }}">Sign In</a>
        @endauth
    </header>

    <main class="nf-landing-hero">
        <div class="nf-landing-content">
            <h1>Unlimited movies, series, and more.</h1>
            <p>Watch anywhere. Cancel anytime.</p>
            <p style="font-size: 1.25rem; margin-top: 1.5rem;">Ready to watch? Enter your email to create or restart your membership.</p>
            
            <div class="nf-cta-form">
                <input type="email" placeholder="Email address" class="nf-cta-input">
                <a class="nf-btn nf-btn-danger nf-cta-btn" href="{{ route('register') }}">
                    Get Started
                    <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </main>

    <section class="nf-landing-features">
        <div class="nf-feature">
            <div class="nf-feature-text">
                <h2>Enjoy on your TV.</h2>
                <p>Watch on Smart TVs, Playstation, Xbox, Apple TV, Chromecast, Blu-ray players, and more.</p>
            </div>
            <div class="nf-feature-img">
                <img src="https://assets.nflxext.com/ffe/siteui/acquisition/ourStory/fuji/desktop/tv.png" alt="TV">
            </div>
        </div>
    </section>

    <style>
        .nf-landing-hero {
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background-image: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.3) 60%, rgba(0,0,0,0.8) 100%), url('https://assets.nflxext.com/ffe/siteui/vlv3/f841d4c7-10e1-40af-bca1-0744f902144f/af6a5367-e9a0-4354-9a4d-f4a4347716ed/ET-en-20220502-popsignuptwoweeks-perspective_alpha_website_large.jpg');
            background-size: cover;
            background-position: center;
            padding: 0 1.5rem;
        }
        .nf-landing-content {
            max-width: 800px;
            animation: fadeIn 1s var(--ease-out);
        }
        .nf-landing-content h1 {
            font-size: clamp(2rem, 7vw, 4rem);
            font-weight: 800;
            margin-bottom: 1rem;
        }
        .nf-landing-content p {
            font-size: clamp(1.1rem, 3vw, 1.5rem);
            font-weight: 400;
        }
        .nf-cta-form {
            display: flex;
            gap: 0.5rem;
            margin-top: 2rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        .nf-cta-input {
            width: 100%;
            max-width: 450px;
            height: 60px;
            padding: 0 20px;
            font-size: 1rem;
            border-radius: 4px;
            border: 1px solid rgba(255,255,255,0.3);
            background: rgba(0,0,0,0.5);
            color: #fff;
            backdrop-filter: blur(4px);
        }
        .nf-cta-input:focus {
            outline: 2px solid #fff;
            border: none;
        }
        .nf-cta-btn {
            height: 60px;
            font-size: 1.5rem;
            padding: 0 2rem;
        }
        .nf-landing-features {
            background: #000;
            padding: 4rem 0;
            border-top: 8px solid #222;
        }
        .nf-feature {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 2rem;
            padding: 4rem 1.5rem;
        }
        .nf-feature-text {
            flex: 1;
        }
        .nf-feature-text h2 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .nf-feature-text p {
            font-size: 1.5rem;
        }
        .nf-feature-img {
            flex: 1;
        }
        .nf-feature-img img {
            width: 100%;
        }
        @media (max-width: 900px) {
            .nf-feature {
                flex-direction: column;
                text-align: center;
            }
            .nf-feature-text h2 { font-size: 2rem; }
            .nf-feature-text p { font-size: 1.1rem; }
        }
    </style>
</x-layouts.netflix>
