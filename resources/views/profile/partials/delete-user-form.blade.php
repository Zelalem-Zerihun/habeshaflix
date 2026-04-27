<section>
    <header>
        <h2 style="font-size: 1.25rem; font-weight: 600; color: #fff; margin: 0 0 0.5rem 0;">
            {{ __('Delete Account') }}
        </h2>

        <p style="color: #b3b3b3; font-size: 0.9rem; margin-bottom: 2rem;">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button 
        class="nf-btn nf-btn-danger" 
        style="padding: 0.7rem 2rem;"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div style="background: #141414; color: #fff; border: 1px solid #333; border-radius: 8px;">
            <form method="post" action="{{ route('profile.destroy') }}" style="padding: 2rem;">
                @csrf
                @method('delete')

                <h2 style="font-size: 1.5rem; font-weight: 600; color: #fff; margin: 0 0 1rem 0;">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p style="color: #b3b3b3; font-size: 0.95rem; line-height: 1.6; margin-bottom: 2rem;">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <div>
                    <label for="password" style="display: block; margin-bottom: 0.5rem; color: #fff;">{{ __('Password') }}</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="{{ __('Password') }}"
                        style="width: 100%; padding: 0.75rem; background: #333; border: 1px solid #444; border-radius: 4px; color: #fff;"
                    />
                    <x-input-error :messages="$errors->userDeletion->get('password')" style="color: #e50914; font-size: 0.85rem; margin-top: 0.25rem;" />
                </div>

                <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
                    <button type="button" class="nf-btn nf-btn-muted" x-on:click="$dispatch('close')" style="padding: 0.6rem 1.5rem;">
                        {{ __('Cancel') }}
                    </button>

                    <button type="submit" class="nf-btn nf-btn-danger" style="padding: 0.6rem 1.5rem;">
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</section>
