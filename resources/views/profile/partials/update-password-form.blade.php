<section>
    <header>
        <h2 style="font-size: 1.25rem; font-weight: 600; color: #fff; margin: 0 0 0.5rem 0;">
            {{ __('Update Password') }}
        </h2>

        <p style="color: #b3b3b3; font-size: 0.9rem; margin-bottom: 2rem;">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" style="display: grid; gap: 1.5rem;">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" style="display: block; margin-bottom: 0.5rem; color: #fff;">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                style="width: 100%; padding: 0.75rem; background: #333; border: 1px solid #444; border-radius: 4px; color: #fff;">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" style="color: #e50914; font-size: 0.85rem; margin-top: 0.25rem;" />
        </div>

        <div>
            <label for="update_password_password" style="display: block; margin-bottom: 0.5rem; color: #fff;">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                style="width: 100%; padding: 0.75rem; background: #333; border: 1px solid #444; border-radius: 4px; color: #fff;">
            <x-input-error :messages="$errors->updatePassword->get('password')" style="color: #e50914; font-size: 0.85rem; margin-top: 0.25rem;" />
        </div>

        <div>
            <label for="update_password_password_confirmation" style="display: block; margin-bottom: 0.5rem; color: #fff;">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                style="width: 100%; padding: 0.75rem; background: #333; border: 1px solid #444; border-radius: 4px; color: #fff;">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" style="color: #e50914; font-size: 0.85rem; margin-top: 0.25rem;" />
        </div>

        <div style="display: flex; align-items: center; gap: 1rem;">
            <button type="submit" class="nf-btn nf-btn-danger" style="padding: 0.7rem 2rem;">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
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
