<?php

namespace App\Livewire\Frontend\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.frontend')]
#[Title('Change Password')]
class ChangePassword extends Component
{
    public User $user;

    #[Validate('required|string|min:6|confirmed')]
    public string $password = '';

    #[Validate('required|string|min:6')]
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(401);
        }

        $this->user = $user;

        // Check authorization - must be the authenticated user
        if ($this->user->id !== $user->id) {
            redirect()->route('frontend.users.profile', $this->user->username);
        }
    }

    /**
     * Update the user password.
     */
    public function updatePassword()
    {
        $this->validate();

        $this->user->update([
            'password' => $this->password,
        ]);

        $this->reset(['password', 'password_confirmation']);

        session()->flash('flash_success', 'Password updated successfully!');

        return redirect()->route('frontend.users.profile', $this->user->username);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $module_title = 'Users';
        $module_name = 'users';
        $module_path = 'users';
        $module_icon = 'fas fa-users';
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Change Password';
        $body_class = 'profile-page';

        $$module_name_singular = $this->user;

        return view(
            'livewire.frontend.users.change-password',
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_action',
                'module_name_singular',
                $module_name_singular,
                'body_class'
            )
        );
    }
}
