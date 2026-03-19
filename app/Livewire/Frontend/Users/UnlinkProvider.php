<?php

namespace App\Livewire\Frontend\Users;

use App\Models\User;
use App\Models\UserProvider;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Component;

class UnlinkProvider extends Component
{
    #[Locked]
    public int $userProviderId;

    public string $providerName = '';

    public function mount(int $userProviderId): void
    {
        $provider = UserProvider::findOrFail($userProviderId);

        $this->userProviderId = $provider->id;
        $this->providerName = $provider->provider ?? 'provider';
    }

    /**
     * @throws Exception
     */
    public function unlink(): void
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(401);
        }

        $provider = UserProvider::findOrFail($this->userProviderId);

        if ((int) $provider->user_id !== (int) $user->id) {
            throw new Exception('There was a problem updating this user. Please try again.');
        }

        $provider->delete();

        $this->dispatch('provider-unlinked');
    }

    public function render()
    {
        return view('livewire.frontend.users.unlink-provider');
    }
}
