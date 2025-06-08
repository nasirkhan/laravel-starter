<?php

namespace App\Livewire\Auth;

use App\Events\Frontend\UserRegistered;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Register')]
#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = $validated['password'];

        $user = User::create($validated);

        $username = intval(config('app.initial_username')) + $user->id;
        $user->username = strval($username);
        $user->last_ip = optional(request())->getClientIp();
        $user->save();

        // event(new Registered($user));
        event(new UserRegistered($user));

        Auth::login($user);

        $this->redirect(route('home', absolute: false), navigate: true);
    }
}
