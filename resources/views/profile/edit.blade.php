<x-layouts.netflix title="HabeshaFlix - Edit Profile">
    <header class="nf-header">
        <a class="nf-logo" href="{{ route('home') }}">HABESHAFLIX</a>
        <a class="nf-btn nf-btn-muted nf-small-btn" href="{{ route('home') }}">Back to Home</a>
    </header>

    <main class="nf-content" style="max-width: 800px; margin: 2rem auto;">
        <h1 style="margin-bottom: 2rem; font-size: 2.5rem;">Account Settings</h1>

        <div style="display: grid; gap: 2rem;">
            <div class="nf-card" style="padding: 2rem;">
                <div style="max-width: 600px;">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="nf-card" style="padding: 2rem;">
                <div style="max-width: 600px;">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="nf-card" style="padding: 2rem; border-top: 4px solid #e50914;">
                <div style="max-width: 600px;">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </main>
</x-layouts.netflix>
