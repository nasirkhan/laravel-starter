<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('components.layouts.frontend')] #[Title('User Profile')] class extends Component {
    public string $username = '';

    public string $module_title = 'Users';

    public string $module_name = 'users';

    public string $module_name_singular = 'user';

    public string $module_icon = 'fas fa-users';

    public string $module_action = 'Profile';

    public string $body_class = 'profile-page';

    public string $meta_page_type = 'profile';

    #[Locked]
    public ?User $user = null;

    public function mount(?string $username = null): void
    {
        $authUser = Auth::user();

        if (! $authUser instanceof User) {
            $this->username = $username ?? '';
        } else {
            $this->username = $username ?? $authUser->username;
        }

        $this->user = User::whereUsername($this->username)->firstOrFail();
    }
};
