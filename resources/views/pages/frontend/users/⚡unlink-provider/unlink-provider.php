<?php

use App\Models\UserProvider;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Component;

new class extends Component
{
    #[Locked]
    public int $userProviderId = 0;

    #[Locked]
    public string $providerName = '';

    public function mount(int $userProviderId): void
    {
        $this->userProviderId = $userProviderId;

        $userProvider = UserProvider::find($userProviderId);
        if ($userProvider) {
            $this->providerName = $userProvider->provider ?? '';
        }
    }

    /**
     * Unlink the social provider from the user account.
     *
     * @throws Exception
     */
    public function unlink(): void
    {
        $user = Auth::user();

        if (! $user) {
            abort(401);
        }

        if (! $this->userProviderId > 0) {
            flash('Invalid Request. Please try again.')->error();

            return;
        }

        $userProvider = UserProvider::findOrFail($this->userProviderId);

        // Verify the provider belongs to the authenticated user
        if ($user->id !== $userProvider->user->id) {
            flash('<i class="fas fa-exclamation-triangle"></i> Request rejected. Please contact the Administrator!')->warning();

            throw new Exception('There was a problem updating this user. Please try again.');
        }

        $providerName = $userProvider->provider ?? 'provider';
        $userProvider->delete();

        flash('<i class="fas fa-check-circle"></i> Successfully unlinked '.$providerName.' from your account!')->success();

        $this->dispatch('provider-unlinked');
    }
};
