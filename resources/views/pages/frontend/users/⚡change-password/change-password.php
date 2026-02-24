<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Layout('components.layouts.frontend')] #[Title('Change Password')] class extends Component {
    #[Locked]
    public ?User $user = null;

    #[Validate('required|string|min:6|confirmed')]
    public string $password = '';

    #[Validate('required|string|min:6')]
    public string $password_confirmation = '';

    public string $module_title = 'Users';

    public string $module_name = 'users';

    public string $module_name_singular = 'user';

    public string $module_icon = 'fas fa-users';

    public string $module_action = 'Change Password';

    public string $body_class = 'profile-page';

    public function mount(): void
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(401);
        }

        $this->user = $user;

        // Check authorization - must be the authenticated user
        if ($this->user->id !== $user->id) {
            redirect()->route('frontend.users.profile', parameters: $this->user->username);
        }
    }

    public function updatePassword(): mixed
    {
        $this->validate();

        $this->user->update([
            'password' => $this->password,
        ]);

        $this->reset(['password', 'password_confirmation']);

        session()->flash(key: 'flash_success', value: 'Password updated successfully!');

        return redirect()->route('frontend.users.profile', parameters: $this->user->username);
    }
};
