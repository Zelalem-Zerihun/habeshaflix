<section>
    <header>
        <h2 style="font-size: 1.25rem; font-weight: 600; color: #fff; margin: 0 0 0.5rem 0;">
            {{ __('Profile Information') }}
        </h2>

        <p style="color: #b3b3b3; font-size: 0.9rem; margin-bottom: 2rem;">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" style="display: grid; gap: 1.5rem;">
        @csrf
        @method('patch')

        <div>
            <label for="name" style="display: block; margin-bottom: 0.5rem; color: #fff;">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" 
                style="width: 100%; padding: 0.75rem; background: #333; border: 1px solid #444; border-radius: 4px; color: #fff;">
            <x-input-error class="mt-2" :messages="$errors->get('name')" style="color: #e50914; font-size: 0.85rem; margin-top: 0.25rem;" />
        </div>

        <div>
            <label for="email" style="display: block; margin-bottom: 0.5rem; color: #fff;">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                style="width: 100%; padding: 0.75rem; background: #333; border: 1px solid #444; border-radius: 4px; color: #fff;">
            <x-input-error class="mt-2" :messages="$errors->get('email')" style="color: #e50914; font-size: 0.85rem; margin-top: 0.25rem;" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p style="font-size: 0.9rem; color: #fff; margin-top: 0.5rem;">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" style="background: transparent; border: none; color: #e50914; text-decoration: underline; cursor: pointer; padding: 0;">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p style="margin-top: 0.5rem; font-weight: 500; font-size: 0.85rem; color: #10b981;">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div style="display: flex; align-items: center; gap: 1rem;">
            <button type="submit" class="nf-btn nf-btn-danger" style="padding: 0.7rem 2rem;">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    style="color: #10b981; font-size: 0.9rem;"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
