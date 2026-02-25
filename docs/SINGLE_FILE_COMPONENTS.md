# Single-File Components (SFC) Implementation Guide

**Version:** 2.0  
**Date:** February 23, 2026  
**Context:** Laravel Starter v13.0.0 - Livewire v4.0 SFC

---

## Table of Contents

1. [Overview](#overview)
2. [SFC in Livewire 4.0](#sfc-in-livewire-40)
3. [Official Livewire v4 SFC Syntax](#official-livewire-v4-sfc-syntax)
4. [Creating SFC Components](#creating-sfc-components)
5. [Component Structure](#component-structure)
6. [Migration Guide](#migration-guide)
7. [Examples](#examples)
8. [Best Practices](#best-practices)

---

## Overview

### What are Single-File Components (SFC)?

Single-File Components (SFC) in Livewire v4 allow you to define a component's logic and template in a single `.blade.php` file. This eliminates the need for separate PHP class files and Blade view files, making components more portable and easier to maintain.

### Why Use SFC?

1. **Improved Developer Experience** - All component code in one place
2. **Better Maintainability** - Easier to understand component relationships
3. **Enhanced Portability** - Components can be easily moved or shared
4. **Reduced File Switching** - No need to jump between PHP and Blade files
5. **Clearer Component Boundaries** - Explicit component ownership

---

## SFC in Livewire 4.0

### Official Livewire v4 SFC Format

Livewire v4 introduces native SFC support using a special syntax that combines PHP class definition and Blade template in a single file:

```php
<?php

use Livewire\Component;

new class extends Component {
    public $title = '';

    public function save()
    {
        // Save logic here...
    }
};
?>

<div>
    <input wire:model="title" type="text">
    <button wire:click="save">Save Post</button>
</div>
```

### Key Features

- **`new class extends Component`** - Defines the component class inline
- **PHP logic at the top** - All PHP code goes before the closing `?>`
- **Blade template at the bottom** - HTML/Blade content after the PHP block
- **No separate files** - Everything in one `.blade.php` file
- **Full Livewire features** - All attributes, methods, and lifecycle hooks work

---

## Official Livewire v4 SFC Syntax

### Basic Structure

```php
<?php

use Livewire\Component;

new class extends Component {
    // Public properties
    public $name = '';
    public $email = '';

    // Public methods
    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Logic here...
    }
};
?>

<div>
    <form wire:submit="submit">
        <input type="text" wire:model="name" placeholder="Name">
        <input type="email" wire:model="email" placeholder="Email">
        <button type="submit">Submit</button>
    </form>
</div>
```

### Using Attributes

```php
<?php

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Title('My Page')]
#[Layout('components.layouts.app')]
new class extends Component {
    public function render()
    {
        return;
    }
};
?>

<div>
    <h1>My Page</h1>
</div>
```

### Using Traits

```php
<?php

use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public function render()
    {
        return;
    }
};
?>

<div>
    @foreach($this->items as $item)
        <p>{{ $item->name }}</p>
    @endforeach

    {{ $this->links() }}
</div>
```

### Lifecycle Hooks

```php
<?php

use Livewire\Component;

new class extends Component {
    public $data = [];

    public function mount($id = null)
    {
        if ($id) {
            $this->data = Model::find($id);
        }
    }

    public function updated($property)
    {
        // Called when a property is updated
    }

    public function render()
    {
        return;
    }
};
?>

<div>
    <!-- Template -->
</div>
```

---

## Creating SFC Components

### Using Artisan Command

Livewire v4's `make:livewire` command automatically creates SFC files by default:

```bash
php artisan make:livewire Terms
```

This creates: `resources/views/livewire/frontend/⚡ terms.blade.php`

### Manual Creation

1. Create a `.blade.php` file in your Livewire views directory
2. Add the PHP class definition at the top
3. Add the Blade template at the bottom

Example: `resources/views/livewire/frontend/⚡ terms.blade.php`

```php
<?php

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Terms and Conditions')]
new class extends Component {
    public $title = 'Terms and Conditions';
    public $company_name;

    public function mount()
    {
        $this->company_name = app_name();
    }
};
?>

<div>
    <h1>{{ $title }}</h1>
    <p>Welcome to {{ $company_name }}!</p>
</div>
```

---

## Component Structure

### File Naming Convention

Livewire v4 uses emoji prefixes for better visual organization:

| Component Type | Emoji Prefix | Example |
|---------------|---------------|----------|
| Pages | ⚡ | `⚡ terms.blade.php` |
| Forms | 📝 | `📝 contact.blade.php` |
| Tables | 📊 | `📊 users.blade.php` |
| Cards | 🃏 | `🃏 profile.blade.php` |
| Modals | 🪟 | `🪟 confirm.blade.php` |

### Directory Structure

```
resources/views/livewire/
├── frontend/
│   ├── ⚡ home.blade.php
│   ├── ⚡ terms.blade.php
│   └── ⚡ privacy.blade.php
├── auth/
│   ├── 🔐 login.blade.php
│   ├── 🔐 register.blade.php
│   └── 🔐 forgot-password.blade.php
└── backend/
    └── 📊 users.blade.php
```

---

## Migration Guide

### Migrating from Traditional Livewire Components

#### Before (Traditional)

**PHP Class:** `app/Livewire/Frontend/Terms.php`
```php
<?php

namespace App\Livewire\Frontend;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Terms and Conditions')]
class Terms extends Component
{
    public function render()
    {
        $title = 'Terms and Conditions';
        $company_name = app_name();

        return view('livewire.frontend.terms', compact('title', 'company_name'));
    }
}
```

**Blade View:** `resources/views/livewire/frontend/terms.blade.php`
```blade
<div>
    <h1>{{ $title }}</h1>
    <p>Welcome to {{ $company_name }}!</p>
</div>
```

#### After (SFC)

**Single File:** `resources/views/livewire/frontend/⚡ terms.blade.php`
```php
<?php

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Terms and Conditions')]
new class extends Component {
    public $title = 'Terms and Conditions';
    public $company_name;

    public function mount()
    {
        $this->company_name = app_name();
    }
};
?>

<div>
    <h1>{{ $title }}</h1>
    <p>Welcome to {{ $company_name }}!</p>
</div>
```

### Migration Steps

1. **Identify components to migrate**
   - Simple static components (Terms, Privacy, Home)
   - Form components (Login, Register, etc.)
   - Complex components (Profile, UsersIndex, etc.)

2. **Create SFC file**
   - Create new `.blade.php` file with emoji prefix
   - Use `new class extends Component` syntax
   - Move PHP logic to the top
   - Move Blade template to the bottom

3. **Update routes** (if needed)
   - Routes remain the same for SFC components
   - Livewire auto-discovers SFC files

4. **Delete old files**
   - Remove PHP class file
   - Remove old Blade view file

5. **Test**
   - Verify component renders correctly
   - Test all functionality

---

## Examples

### Example 1: Simple Static Component

**File:** `resources/views/livewire/frontend/⚡ terms.blade.php`

```php
<?php

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Terms and Conditions')]
new class extends Component {
    public $title = 'Terms and Conditions';
    public $company_name;

    public function mount()
    {
        $this->company_name = app_name();
    }
};
?>

<div>
    <x-cube::header-block :title="$title" />

    <section class="mx-auto max-w-screen-xl bg-white p-6 text-gray-600 sm:p-20">
        <div class="grid grid-cols-1">
            <p>Welcome to {{ app_name() }}!</p>
            <p>
                These terms and conditions outline the rules and regulations for the use of 
                {{ $company_name }}'s Website.
            </p>
            <!-- More content... -->
        </div>
    </section>
</div>
```

### Example 2: Form Component with Validation

**File:** `resources/views/livewire/auth/🔐 login.blade.php`

```php
<?php

use App\Events\Auth\UserLoginSuccess;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Title('Login')]
#[Layout('components.layouts.auth')]
new class extends Component {
    #[Validate('required|string|email')]
    public $email = '';

    #[Validate('required|string')]
    public $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate();
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(
            credentials: ['email' => $this->email, 'password' => $this->password, 'status' => 1],
            remember: $this->remember
        )) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $user = Auth::user();
        event(new UserLoginSuccess(request(), $user));

        RateLimiter::clear($this->throttleKey());
        session()->regenerate();

        $this->redirect(route('frontend.index'), navigate: true);
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
};
?>

<div>
    <div class="flex min-h-screen items-center justify-center bg-gray-100 px-4 py-12 dark:bg-gray-900 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div>
                <img class="mx-auto h-12 w-auto" src="{{ asset('img/logo.jpg') }}" alt="{{ app_name() }}" />
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
                    {{ __('Sign in to your account') }}
                </h2>
            </div>

            <form class="mt-8 space-y-6" wire:submit="login">
                <div>
                    <label for="email" class="sr-only">{{ __('Email address') }}</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        wire:model="email"
                        autocomplete="email"
                        required
                        class="relative block w-full appearance-none rounded-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 focus:z-10 sm:text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        placeholder="{{ __('Email address') }}"
                    />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="sr-only">{{ __('Password') }}</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        wire:model="password"
                        autocomplete="current-password"
                        required
                        class="relative block w-full appearance-none rounded-none rounded-b-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 focus:z-10 sm:text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        placeholder="{{ __('Password') }}"
                    />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        {{ __('Sign in') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
```

### Example 3: Component with Pagination

**File:** `resources/views/livewire/backend/📊 users.blade.php`

```php
<?php

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Users')]
new class extends Component {
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $role = 'all';

    #[Url]
    public int $perPage = 15;

    public function render()
    {
        $users = User::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->role !== 'all', fn($q) => $q->whereRole($this->role))
            ->latest()
            ->paginate($this->perPage);

        return;
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
        session()->flash('success', 'User deleted successfully!');
    }
};
?>

<div>
    <div class="mb-4 flex justify-between">
        <input 
            type="text" 
            wire:model.live="search" 
            placeholder="Search users..."
            class="rounded border px-4 py-2"
        />
        
        <select wire:model="role" class="rounded border px-4 py-2">
            <option value="all">All Roles</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
    </div>

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            @foreach($users as $user)
                <tr>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{{ $user->id }}</td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{{ $user->name }}</td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{{ $user->email }}</td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                        <a href="{{ route('backend.users.show', $user) }}" class="text-blue-600 hover:text-blue-900">View</a>
                        <button wire:click="deleteUser({{ $user->id }})" class="ml-2 text-red-600 hover:text-red-900">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</div>
```

---

## Best Practices

### 1. Use Descriptive Property Names

```php
<?php

new class extends Component {
    public $pageTitle = 'My Page';  // Good
    public $t = 'My Page';         // Bad - too short
};
?>
```

### 2. Use Type Hints

```php
<?php

new class extends Component {
    public string $name = '';
    public int $age = 0;
    public bool $isActive = false;
    public array $items = [];
};
?>
```

### 3. Use PHP Attributes

```php
<?php

use Livewire\Attributes\Locked;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;

new class extends Component {
    #[Locked]
    public User $user;

    #[Reactive]
    public $search = '';

    #[Url]
    public $page = 1;

    #[Validate('required|string|max:255')]
    public $name = '';
};
?>
```

### 4. Keep Components Focused

Each component should have a single responsibility. If a component becomes too complex, consider breaking it into smaller components.

### 5. Use the `mount()` Method

Use the `mount()` method for initialization instead of the constructor:

```php
<?php

new class extends Component {
    public $data;

    public function mount($id = null)
    {
        $this->data = Model::find($id);
    }
};
?>
```

### 6. Use Validation Attributes

```php
<?php

use Livewire\Attributes\Validate;

new class extends Component {
    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|email|max:255')]
    public $email = '';

    public function submit()
    {
        $this->validate();  // Validates all #[Validate] attributes
    }
};
?>
```

---

## Configuration

### Livewire Config

The `config/livewire.php` file controls SFC behavior:

```php
'make_command' => [
    // 'type' => 'class',  // Match v3 behavior (not SFC)
    'emoji' => true,        // Add emoji prefixes to file names
],
```

### Component Locations

Livewire looks for SFC files in these directories:

```php
'component_locations' => [
    resource_path('views/components'),
    resource_path('views/livewire'),
],
```

---

## Testing SFC Components

Test SFC components the same way as regular Livewire components:

```php
<?php

namespace Tests\Livewire\Frontend;

use Livewire\Livewire;
use Tests\TestCase;

class TermsTest extends TestCase
{
    public function test_component_renders(): void
    {
        Livewire::test('frontend.⚡ terms')
            ->assertStatus(200)
            ->assertSee('Terms and Conditions');
    }
}
```

---

## Benefits of SFC

1. **Single Source of Truth** - All component code in one file
2. **Easier Navigation** - No need to switch between files
3. **Better Portability** - Easy to copy/paste components
4. **Reduced File Count** - Fewer files to manage
5. **Improved DX** - Faster development workflow

---

## Conclusion

Single-File Components (SFC) in Livewire v4 provide a clean, efficient way to build components. By using the `new class extends Component` syntax, you can define both logic and template in a single file, improving developer experience and maintainability.

### Key Takeaways

- Use `new class extends Component` syntax
- PHP logic goes at the top
- Blade template goes at the bottom
- Use emoji prefixes for better organization
- All Livewire features work in SFC

---

**Document Version:** 2.0  
**Last Updated:** February 23, 2026  
**Reference:** Official Livewire v4 Documentation
