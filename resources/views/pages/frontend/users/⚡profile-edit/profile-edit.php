<?php

use App\Models\User;
use App\Models\UserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts::frontend')] #[Title('Edit Profile')] class extends Component
{
    use WithFileUploads;

    #[Locked]
    public ?User $user = null;

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

    public string $module_title = 'Users';

    public string $module_name = 'users';

    public string $module_name_singular = 'user';

    public string $module_icon = 'fas fa-users';

    public string $module_action = 'Edit Profile';

    public string $body_class = 'profile-page';

    #[Locked]
    public array $providerNames = [];

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
        $this->syncProviderNames();
    }

    public function update(): mixed
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

        session()->flash(key: 'flash_success', value: 'Update successful!');

        return redirect()->route('frontend.users.profile', parameters: $this->user->username);
    }

    public function resendEmailConfirmation(): void
    {
        if (! $this->user instanceof User || $this->user->id !== Auth::id()) {
            abort(401);
        }

        if ($this->user->email_verified_at !== null) {
            Log::info($this->user->name.' ('.$this->user->id.') - User requested but email already verified at '.$this->user->email_verified_at);

            flash(
                $this->user->name.', You already confirmed your email address at '.$this->user->email_verified_at->isoFormat('LL')
            )->success()->important();

            return;
        }

        Log::info($this->user->name.' ('.$this->user->id.') - User requested for email verification.');
        $this->user->sendEmailVerificationNotification();

        flash('Email Sent! Please Check Your Inbox.')->success()->important();
    }

    public function unlinkProvider(int $userProviderId): void
    {
        if (! $this->user instanceof User || $this->user->id !== Auth::id()) {
            abort(401);
        }

        if ($userProviderId <= 0) {
            flash('Invalid Request. Please try again.')->error();

            return;
        }

        $userProvider = UserProvider::findOrFail($userProviderId);

        if ($this->user->id !== $userProvider->user_id) {
            flash('<i class="fas fa-exclamation-triangle"></i> Request rejected. Please contact the Administrator!')->warning();
            abort(403);
        }

        $providerName = $userProvider->provider ?? 'provider';
        $userProvider->delete();

        $this->user->refresh();
        $this->syncProviderNames();

        flash('<i class="fas fa-check-circle"></i> Successfully unlinked '.$providerName.' from your account!')->success();
    }

    protected function syncProviderNames(): void
    {
        $this->providerNames = $this->user?->providers
            ?->mapWithKeys(fn ($provider) => [$provider->id => $provider->provider ?? 'provider'])
            ->all() ?? [];
    }
};
