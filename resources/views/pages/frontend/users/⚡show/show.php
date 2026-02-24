<?php

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('components.layouts.frontend')] #[Title('User Profile')] class extends Component {
    #[Locked]
    public ?User $user = null;

    public string $username = '';

    public string $module_title = 'Users';

    public string $module_name = 'users';

    public string $module_name_singular = 'user';

    public string $module_icon = 'fas fa-users';

    public string $module_action = 'Show';

    public string $body_class = 'profile-page';

    public string $meta_page_type = 'profile';

    public function mount(string $username): void
    {
        $this->username = $username;
        $this->user = User::where('username', 'LIKE', $username)->firstOrFail();
    }
};
