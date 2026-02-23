# Blade Component Documentation

**Last Updated:** February 23, 2026  
**Laravel Version:** 12.x  
**Livewire Version:** 4.x

This document provides comprehensive documentation for all Blade components in the Laravel Starter application, including usage examples, prop validation, and Alpine.js integration patterns.

---

## ⚡ Livewire Single-File Components (SFC)

Livewire 4.0 introduces native Single-File Components (SFC) that allow you to define a component's logic and template in a single `.blade.php` file.

### What is SFC?

Single-File Components combine PHP class definition and Blade template in one file:

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

### SFC vs Traditional Components

| Aspect | Traditional | SFC |
|---------|-------------|-------|
| Files | 2 files (PHP class + Blade view) | 1 file (.blade.php) |
| Syntax | `class MyComponent extends Component` | `new class extends Component` |
| Location | `app/Livewire/` + `resources/views/livewire/` | `resources/views/livewire/` |
| File Naming | `MyComponent.php` + `my-component.blade.php` | `⚡ my-component.blade.php` |

### Creating SFC Components

#### Using Artisan Command

```bash
# Create a new SFC component
php artisan make:livewire Terms

# This creates: resources/views/livewire/frontend/⚡ terms.blade.php
```

#### Manual Creation

Create a `.blade.php` file in your Livewire views directory:

```php
<?php

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Page')]
new class extends Component {
    public $title = 'My Page';
    public $data = [];

    public function mount()
    {
        // Initialization logic
        $this->data = Model::all();
    }
};
?>

<div>
    <h1>{{ $title }}</h1>
    @foreach($data as $item)
        <p>{{ $item->name }}</p>
    @endforeach
</div>
```

### SFC Features

#### PHP Attributes

Use Livewire attributes for component metadata:

```php
<?php

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Locked;

#[Title('Page Title')]
#[Layout('components.layouts.app')]
new class extends Component {
    #[Locked]
    public User $user;

    #[Url]
    public $page = 1;

    #[Validate('required|string|max:255')]
    public $name = '';
};
?>
```

#### Lifecycle Hooks

```php
<?php

new class extends Component {
    public function mount($id = null)
    {
        // Called when component is initialized
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
        // Optional - can be omitted for simple components
        return;
    }
};
?>
```

#### Using Traits

```php
<?php

use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public function render()
    {
        $items = Model::paginate(15);
        return;
    }
};
?>
```

### SFC File Organization

Livewire SFC files are organized with emoji prefixes:

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

### Emoji Prefixes

| Component Type | Emoji | Example |
|---------------|--------|----------|
| Pages | ⚡ | `⚡ home.blade.php` |
| Forms | 📝 | `📝 contact.blade.php` |
| Tables | 📊 | `📊 users.blade.php` |
| Cards | 🃏 | `🃏 profile.blade.php` |
| Modals | 🪟 | `🪟 confirm.blade.php` |
| Auth | 🔐 | `🔐 login.blade.php` |

### Migration Guide

For detailed migration instructions from traditional Livewire components to SFC, see:
- [UPGRADE.md - Upgrading to Livewire 4.0 SFC](../UPGRADE.md#upgrading-to-livewire-40-sfc)
- [SINGLE_FILE_COMPONENTS.md](SINGLE_FILE_COMPONENTS.md)

---

## 📂 Component Organization

Components are organized by feature and context to improve discoverability and maintainability:

```
resources/views/components/
├── frontend/        # Frontend components (Tailwind CSS + Alpine.js)
│   ├── ui/          # Base UI components (buttons, inputs, modals)
│   ├── forms/       # Form-specific components with validation
│   ├── navigation/  # Navigation components (nav, breadcrumbs)
│   ├── form/        # Existing frontend form components
│   └── social/      # Social media components
├── backend/         # Backend admin components (Bootstrap)
│   ├── buttons/     # Bootstrap-based action buttons
│   ├── layouts/     # Backend layout components
│   └── includes/    # Backend partial includes
├── layouts/         # Shared layout components
└── library/         # Third-party library integrations (lightbox, select2)
```

**Note:** Frontend uses Tailwind CSS with Alpine.js (included with Livewire 3), while Backend uses Bootstrap.

---

## 🎨 UI Components

### Buttons

#### Primary Button
**File:** `resources/views/components/frontend/ui/buttons/primary.blade.php`

Primary action button with dark mode support.

**Props:**
- `type` (string, default: 'submit') - Button type
- `disabled` (bool, default: false) - Disabled state

**Usage:**
```blade
<x-frontend.ui.buttons.primary>
    Save Changes
</x-ui.buttons.primary>

<x-ui.buttons.primary type="button" disabled>
    Processing...
</x-ui.buttons.primary>
```

**With Alpine.js:**
```blade
<x-ui.buttons.primary 
    x-on:click="submitForm"
    x-bind:disabled="loading">
    <span x-show="!loading">Submit</span>
    <span x-show="loading">Loading...</span>
</x-ui.buttons.primary>
```

---

#### Secondary Button
**File:** `resources/views/components/frontend/ui/buttons/secondary.blade.php`

Secondary action button for less prominent actions.

**Props:**
- `type` (string, default: 'button') - Button type

**Usage:**
```blade
<x-ui.buttons.secondary>
    Cancel
</x-ui.buttons.secondary>
```

---

#### Danger Button
**File:** `resources/views/components/frontend/ui/buttons/danger.blade.php`

Destructive action button (delete, remove, etc.).

**Props:**
- `type` (string, default: 'button') - Button type

**Usage:**
```blade
<x-ui.buttons.danger 
    x-on:click="$dispatch('open-modal', 'confirm-delete')">
    Delete Account
</x-ui.buttons.danger>
```

---

### Inputs

#### Text Input
**File:** `resources/views/components/frontend/forms/text-input.blade.php`

Standard text input with dark mode support.

**Props:**
- `disabled` (bool, default: false) - Disabled state
- `type` (string, default: 'text') - Input type
- `required` (bool, default: false) - Required field

**Usage:**
```blade
<x-forms.text-input 
    name="email" 
    type="email" 
    required 
/>

<!-- With Livewire -->
<x-forms.text-input 
    wire:model.live="search" 
    placeholder="Search..." 
/>
```

**With Alpine.js:**
```blade
<x-forms.text-input 
    x-model="username"
    x-on:input.debounce.500ms="checkAvailability"
    ::class="{ 'border-green-500': available, 'border-red-500': !available }"
/>
```

---

#### Checkbox
**File:** `resources/views/components/frontend/forms/checkbox.blade.php`

Styled checkbox input.

**Props:**
- `checked` (bool, default: false) - Checked state
- `value` (string) - Checkbox value

**Usage:**
```blade
<x-forms.checkbox 
    name="remember" 
    value="1" 
/>

<!-- With Alpine.js -->
<x-forms.checkbox 
    x-model="agreed"
    x-bind:disabled="!termsVisible"
/>
```

---

#### Select
**File:** `resources/views/components/frontend/forms/select.blade.php`

Styled select dropdown.

**Props:**
- `options` (array) - Select options
- `selected` (string) - Selected value
- `placeholder` (string) - Placeholder text

**Usage:**
```blade
<x-forms.select 
    name="country" 
    :options="$countries"
    selected="{{ old('country') }}"
/>

<!-- With Alpine.js -->
<x-forms.select 
    x-model="category"
    x-on:change="loadSubcategories"
/>
```

---

### Modal
**File:** `resources/views/components/frontend/ui/modal.blade.php`

Modal dialog with Alpine.js integration, keyboard navigation, and focus management.

**Props:**
- `name` (string, required) - Unique modal identifier
- `show` (bool, default: false) - Initial visibility state
- `maxWidth` (string, default: '2xl') - Maximum width (sm, md, lg, xl, 2xl)
- `focusable` (bool, default: false) - Auto-focus first element

**Usage:**
```blade
<!-- Trigger -->
<x-ui.buttons.primary 
    x-on:click="$dispatch('open-modal', 'confirm-delete')">
    Delete User
</x-ui.buttons.primary>

<!-- Modal -->
<x-ui.modal name="confirm-delete" :show="$errors->isNotEmpty()" focusable>
    <div class="p-6">
        <h2 class="text-lg font-medium">
            Are you sure you want to delete this user?
        </h2>
        
        <p class="mt-4 text-sm text-gray-600">
            This action cannot be undone.
        </p>
        
        <div class="mt-6 flex justify-end gap-3">
            <x-ui.buttons.secondary 
                x-on:click="$dispatch('close-modal', 'confirm-delete')">
                Cancel
            </x-ui.buttons.secondary>
            
            <x-ui.buttons.danger>
                Delete User
            </x-ui.buttons.danger>
        </div>
    </div>
</x-ui.modal>
```

**Events:**
- `open-modal` - Dispatch to open modal: `$dispatch('open-modal', 'modal-name')`
- `close-modal` - Dispatch to close modal: `$dispatch('close-modal', 'modal-name')`
- Close on ESC key press
- Close on backdrop click
- Trap focus within modal when open

---

### Dropdown
**File:** `resources/views/components/frontend/ui/dropdown.blade.php`

Dropdown menu with Alpine.js toggle functionality.

**Props:**
- `align` (string, default: 'right') - Alignment (left, right)
- `width` (string, default: '48') - Dropdown width in rem

**Slots:**
- `trigger` - Dropdown trigger button
- Default slot - Dropdown content

**Usage:**
```blade
<x-ui.dropdown align="right" width="48">
    <x-slot name="trigger">
        <button>
            {{ Auth::user()->name }}
            <svg>...</svg>
        </button>
    </x-slot>

    <x-slot name="content">
        <x-ui.dropdown-link href="{{ route('profile.edit') }}">
            Profile
        </x-ui.dropdown-link>
        <x-ui.dropdown-link href="{{ route('logout') }}">
            Log Out
        </x-ui.dropdown-link>
    </x-slot>
</x-ui.dropdown>
```

**With Alpine.js:**
```blade
<div x-data="{ open: false }">
    <x-ui.dropdown>
        <!-- Dropdown automatically manages open state -->
    </x-ui.dropdown>
</div>
```

---

## 📝 Form Components

### Form Group
**File:** `resources/views/components/frontend/forms/group.blade.php`

Complete form field with label, input, and error display.

**Props:**
- `label` (string, required) - Field label
- `name` (string, required) - Field name
- `required` (bool, default: false) - Required field indicator
- `help` (string) - Help text below input

**Usage:**
```blade
<x-forms.group 
    label="Email Address" 
    name="email" 
    required
    help="We'll never share your email">
    <x-forms.text-input 
        name="email" 
        type="email" 
        required 
    />
</x-forms.group>
```

**With Livewire:**
```blade
<x-forms.group label="Title" name="title" required>
    <x-forms.text-input 
        wire:model.live="title"
        name="title"
    />
</x-forms.group>
@error('title')
    <x-forms.input-error :messages="$message" />
@enderror
```

---

### Input Label
**File:** `resources/views/components/frontend/forms/label.blade.php`

Styled form label with required indicator.

**Props:**
- `for` (string) - Associated input ID
- `value` (string) - Label text
- `required` (bool, default: false) - Show required indicator

**Usage:**
```blade
<x-forms.label for="username" value="Username" required />
<x-forms.text-input id="username" name="username" />
```

---

### Input Error
**File:** `resources/views/components/frontend/forms/error.blade.php`

Display validation errors for form fields.

**Props:**
- `messages` (array|string) - Error messages to display

**Usage:**
```blade
<x-forms.text-input name="email" />
<x-forms.error :messages="$errors->get('email')" />

<!-- Multiple errors -->
<x-forms.error :messages="$errors->all()" />
```

---

## 🧭 Navigation Components

### Nav Link
**File:** `resources/views/components/frontend/navigation/nav-link.blade.php`

Navigation link with active state detection.

**Props:**
- `href` (string, required) - Link URL
- `active` (bool, default: false) - Active state

**Usage:**
```blade
<x-navigation.nav-link 
    href="{{ route('dashboard') }}" 
    :active="request()->routeIs('dashboard')">
    Dashboard
</x-navigation.nav-link>
```

**With Alpine.js:**
```blade
<x-navigation.nav-link 
    href="{{ route('settings') }}"
    x-bind:class="{ 'bg-gray-100': activeTab === 'settings' }">
    Settings
</x-navigation.nav-link>
```

---

### Breadcrumbs
**File:** `resources/views/components/frontend/navigation/breadcrumbs.blade.php`

Breadcrumb navigation component.

**Props:**
- `items` (array) - Breadcrumb items [['label' => 'Home', 'url' => '/'], ...]

**Usage:**
```blade
<x-navigation.breadcrumbs :items="[
    ['label' => 'Home', 'url' => route('home')],
    ['label' => 'Posts', 'url' => route('posts.index')],
    ['label' => 'Create', 'url' => null],
]" />
```

---

### Dynamic Menu
**File:** `resources/views/components/frontend/navigation/dynamic-menu.blade.php`

Dynamically generated menu from database.

**Props:**
- `location` (string, required) - Menu location (header, footer, sidebar)

**Usage:**
```blade
<x-navigation.dynamic-menu location="header" />
<x-navigation.dynamic-menu location="footer" />
```

---

## 🎭 Alpine.js Integration Examples

**Note:** Alpine.js is included with Livewire 3 and is available throughout the application without additional setup.

### Loading States

```blade
<div x-data="{ loading: false }">
    <x-ui.buttons.primary 
        x-on:click="loading = true; submitForm()"
        x-bind:disabled="loading">
        <span x-show="!loading">Save</span>
        <span x-show="loading" class="flex items-center">
            <svg class="animate-spin h-4 w-4 mr-2" ...>...</svg>
            Saving...
        </span>
    </x-ui.buttons.primary>
</div>
```

---

### Form Validation

```blade
<div x-data="{
    email: '',
    validating: false,
    valid: null,
    async validateEmail() {
        this.validating = true;
        const response = await fetch('/api/validate-email', {
            method: 'POST',
            body: JSON.stringify({ email: this.email })
        });
        this.valid = (await response.json()).valid;
        this.validating = false;
    }
}">
    <x-forms.group label="Email" name="email">
        <x-forms.text-input 
            type="email"
            x-model="email"
            x-on:blur="validateEmail"
            ::class="{
                'border-green-500': valid === true,
                'border-red-500': valid === false
            }"
        />
        <span x-show="validating" class="text-sm text-gray-500">
            Validating...
        </span>
        <span x-show="valid === false" class="text-sm text-red-600">
            Email already taken
        </span>
        <span x-show="valid === true" class="text-sm text-green-600">
            Email available
        </span>
    </x-forms.group>
</div>
```

---

### Conditional Rendering

```blade
<div x-data="{ 
    accountType: 'personal',
    showBusinessFields: false 
}" x-init="$watch('accountType', value => showBusinessFields = value === 'business')">
    
    <x-forms.select 
        x-model="accountType"
        :options="['personal' => 'Personal', 'business' => 'Business']"
    />
    
    <div x-show="showBusinessFields" x-transition>
        <x-forms.group label="Company Name" name="company">
            <x-forms.text-input name="company" />
        </x-forms.group>
        
        <x-forms.group label="Tax ID" name="tax_id">
            <x-forms.text-input name="tax_id" />
        </x-forms.group>
    </div>
</div>
```

---

### Debounced Search

```blade
<div x-data="{ 
    search: '',
    results: [],
    async performSearch() {
        const response = await fetch(`/api/search?q=${this.search}`);
        this.results = await response.json();
    }
}">
    <x-forms.text-input 
        type="search"
        placeholder="Search..."
        x-model="search"
        x-on:input.debounce.500ms="performSearch"
    />
    
    <div class="mt-4">
        <template x-for="result in results" :key="result.id">
            <div x-text="result.title"></div>
        </template>
    </div>
</div>
```

---

### Modal Confirmation

```blade
<div x-data="{ selectedId: null }">
    <!-- Delete button -->
    <x-ui.buttons.danger 
        x-on:click="selectedId = {{ $user->id }}; $dispatch('open-modal', 'confirm-user-deletion')">
        Delete User
    </x-ui.buttons.danger>
    
    <!-- Confirmation modal -->
    <x-ui.modal name="confirm-user-deletion">
        <form 
            method="post" 
            :action="`/users/${selectedId}`"
            class="p-6">
            @csrf
            @method('delete')
            
            <h2>Are you sure you want to delete this user?</h2>
            
            <div class="mt-6 flex justify-end gap-3">
                <x-ui.buttons.secondary 
                    type="button"
                    x-on:click="$dispatch('close-modal', 'confirm-user-deletion')">
                    Cancel
                </x-ui.buttons.secondary>
                
                <x-ui.buttons.danger type="submit">
                    Delete
                </x-ui.buttons.danger>
            </div>
        </form>
    </x-ui.modal>
</div>
```

---

### Toggle Switch

```blade
<div x-data="{ enabled: @json($user->notifications_enabled) }">
    <label class="flex items-center cursor-pointer">
        <input 
            type="checkbox" 
            name="notifications_enabled"
            x-model="enabled"
            class="hidden"
        />
        <div 
            x-on:click="enabled = !enabled"
            :class="enabled ? 'bg-blue-600' : 'bg-gray-200'"
            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
            <span 
                :class="enabled ? 'translate-x-6' : 'translate-x-1'"
                class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform">
            </span>
        </div>
        <span class="ml-3" x-text="enabled ? 'Enabled' : 'Disabled'"></span>
    </label>
</div>
```

---

## 📦 Component Best Practices

### 1. Prop Validation

Always validate props with appropriate defaults:

```blade
@props([
    'type' => 'text',
    'required' => false,
    'disabled' => false,
    'placeholder' => '',
])

@php
    // Validate prop values
    $validTypes = ['text', 'email', 'password', 'number', 'url'];
    $type = in_array($type, $validTypes) ? $type : 'text';
@endphp
```

---

### 2. Dark Mode Support

Always include dark mode classes:

```blade
class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100"
```

---

### 3. Accessibility

Include proper ARIA attributes:

```blade
<button 
    type="button"
    aria-label="Close modal"
    aria-expanded="false"
    role="button">
    Close
</button>
```

---

### 4. Responsive Design

Use responsive Tailwind classes:

```blade
class="px-4 py-2 sm:px-6 sm:py-3 text-sm sm:text-base"
```

---

### 5. Alpine.js Best Practices

- Use `x-cloak` to prevent flash of unstyled content
- Use `x-show` for frequently toggled elements
- Use `x-if` for elements that rarely change
- Use `x-transition` for smooth animations
- Use `.debounce` modifier for input events
- Keep Alpine.js data in parent component when possible

---

## 🔧 Creating New Components

### File Naming Convention

```
resources/views/components/
├── {category}/
│   └── {component-name}.blade.php  # kebab-case
```

### Component Template

```blade
{{-- Component: {Category} {Name} --}}
{{-- Description: Brief description of component purpose --}}
{{-- Props: List required and optional props --}}

@props([
    // Required props (no default)
    'name',
    
    // Optional props (with defaults)
    'type' => 'text',
    'required' => false,
    'disabled' => false,
])

@php
    // Prop validation
    $validTypes = ['text', 'email', 'password'];
    $type = in_array($type, $validTypes) ? $type : 'text';
@endphp

<div {{ $attributes->merge(['class' => 'base-classes']) }}>
    {{-- Component content --}}
    {{ $slot }}
</div>
```

---

### Usage Documentation Template

```blade
{{-- Usage:
<x-category.component-name 
    name="fieldName"
    type="email"
    required
/>

With Alpine.js:
<x-category.component-name 
    x-model="email"
    x-on:input="validateEmail"
/>

With Livewire:
<x-category.component-name 
    wire:model.live="email"
/>
--}}
```

---

## 📚 Additional Resources

- [Laravel Blade Components](https://laravel.com/docs/12.x/blade#components)
- [Alpine.js Documentation](https://alpinejs.dev/)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [Livewire Documentation](https://livewire.laravel.com/docs)

---

**Maintained by:** Laravel Starter Team
**Last Review:** February 23, 2026
**Next Review:** March 2026
