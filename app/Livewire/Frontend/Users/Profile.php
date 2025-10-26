<?php

namespace App\Livewire\Frontend\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.frontend')]
#[Title('User Profile')]
class Profile extends Component
{
    public User $user;

    public string $username;

    /**
     * Mount the component.
     */
    public function mount(?string $username = null)
    {
        $authUser = Auth::user();

        if (! $authUser instanceof User) {
            $this->username = $username ?? '';
        } else {
            $this->username = $username ?? $authUser->username;
        }

        $this->user = User::whereUsername($this->username)->firstOrFail();
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
        $module_action = 'Profile';
        $body_class = 'profile-page';
        $meta_page_type = 'profile';

        $$module_name_singular = $this->user;

        return view(
            'livewire.frontend.users.profile',
            compact(
                'module_name',
                'module_name_singular',
                $module_name_singular,
                'module_icon',
                'module_action',
                'module_title',
                'body_class',
                'meta_page_type'
            )
        );
    }
}
