<?php

namespace App\Livewire\Frontend\Users;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.frontend')]
#[Title('User Profile')]
class Show extends Component
{
    public User $user;

    public string $username;

    /**
     * Mount the component.
     */
    public function mount(string $username)
    {
        $this->username = $username;
        $this->user = User::where('username', 'LIKE', $username)->firstOrFail();
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.frontend.users.show', [
            'module_title' => 'Users',
            'module_name' => 'users',
            'module_path' => 'users',
            'module_icon' => 'fas fa-users',
            'module_name_singular' => 'user',
            'module_action' => 'Show',
            'user' => $this->user,
            'body_class' => 'profile-page',
            'meta_page_type' => 'profile',
        ]);
    }
}
