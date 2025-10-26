<?php

namespace App\Livewire\Frontend\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.frontend')]
#[Title('Edit Profile')]
class ProfileEdit extends Component
{
    use WithFileUploads;

    public User $user;

    #[Validate('required|string|max:191')]
    public string $first_name = '';

    #[Validate('required|string|max:191')]
    public string $last_name = '';

    #[Validate('nullable|string|max:191')]
    public string $username = '';

    #[Validate('nullable|email|max:191')]
    public string $email = '';

    #[Validate('nullable|string|max:191')]
    public string $mobile = '';

    #[Validate('nullable|string|max:191')]
    public string $gender = '';

    #[Validate('nullable|date')]
    public ?string $date_of_birth = null;

    #[Validate('nullable|string')]
    public string $address = '';

    #[Validate('nullable|string|max:191')]
    public string $bio = '';

    #[Validate('nullable|url|max:191')]
    public string $url = '';

    #[Validate('nullable|string|max:191')]
    public string $url_text = '';

    #[Validate('nullable|image|max:2048')]
    public $avatar;

    /**
     * Mount the component.
     */
    public function mount()
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(401);
        }

        $this->user = $user;

        // Check authorization - must be the authenticated user
        if ($this->user->id !== $user->id) {
            return redirect()->route('frontend.users.profile', $this->user->username);
        }

        // Populate form fields
        $this->first_name = $this->user->first_name ?? '';
        $this->last_name = $this->user->last_name ?? '';
        $this->username = $this->user->username ?? '';
        $this->email = $this->user->email ?? '';
        $this->mobile = $this->user->mobile ?? '';
        $this->gender = $this->user->gender ?? '';
        $this->date_of_birth = $this->user->date_of_birth?->format('Y-m-d') ?? null;
        $this->address = $this->user->address ?? '';
        $this->bio = $this->user->bio ?? '';
        $this->url = $this->user->url ?? '';
        $this->url_text = $this->user->url_text ?? '';
    }

    /**
     * Update the user profile.
     */
    public function update()
    {
        $this->validate();

        $this->user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'mobile' => $this->mobile,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'address' => $this->address,
            'bio' => $this->bio,
            'url' => $this->url,
            'url_text' => $this->url_text,
        ]);

        // Handle Avatar upload
        if ($this->avatar) {
            if ($this->user->getMedia('users')->first()) {
                $this->user->getMedia('users')->first()->delete();
            }

            $media = $this->user->addMedia($this->avatar->getRealPath())
                ->toMediaCollection('users');

            $this->user->update(['avatar' => $media->getUrl()]);
        }

        session()->flash('flash_success', 'Update successful!');

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
        $module_action = 'Edit Profile';
        $body_class = 'profile-page';

        $$module_name_singular = $this->user;

        return view(
            'livewire.frontend.users.profile-edit',
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
