# Laravel-Cube Checkbox Component - Usage Examples

This document provides practical examples of using the `<x-cube::checkbox>` component from the laravel-cube package.

## Basic Examples

### Simple Checkbox
```blade
<x-cube::checkbox name="remember">Remember me</x-cube::checkbox>
```

### Checkbox with Wire Model
```blade
<x-cube::checkbox wire:model="remember">Remember me</x-cube::checkbox>
```

### Pre-checked Checkbox
```blade
<x-cube::checkbox 
    wire:model="terms_accepted" 
    :checked="true"
>I agree to the terms</x-cube::checkbox>
```

### Required Checkbox
```blade
<x-cube::checkbox 
    wire:model="terms_accepted" 
    required
>I agree to the terms and conditions</x-cube::checkbox>
```

### Disabled Checkbox
```blade
<x-cube::checkbox 
    wire:model="newsletter" 
    disabled
>Subscribe to newsletter</x-cube::checkbox>
```

## Framework-Specific Examples

### Tailwind CSS (Default)
```blade
<x-cube::checkbox 
    wire:model="remember"
>Remember me</x-cube::checkbox>
```

### Bootstrap 5
```blade
<x-cube::checkbox 
    framework="bootstrap"
    wire:model="remember"
>Remember me</x-cube::checkbox>
```

## Advanced Examples

### Checkbox Group
```blade
<div class="space-y-2">
    <p class="font-medium">Select your interests:</p>
    
    <x-cube::checkbox 
        wire:model="interests" 
        value="technology"
    >
        Technology
    </x-cube::checkbox>
    
    <x-cube::checkbox 
        wire:model="interests" 
        value="sports"
    >
        Sports
    </x-cube::checkbox>
    
    <x-cube::checkbox 
        wire:model="interests" 
        value="music"
    >
        Music
    </x-cube::checkbox>
</div>
```

### Checkbox with Error Display
```blade
<div class="space-y-2">
    <x-cube::checkbox 
        wire:model="terms_accepted" 
        required
    >
        I agree to the terms and conditions
    </x-cube::checkbox>
    
    <x-cube::error :messages="$errors->get('terms_accepted')" />
</div>
```

### Checkbox with Label Component
```blade
<div class="space-y-2">
    <x-cube::label for="remember" required>
        Remember me
    </x-cube::label>
    
    <x-cube::checkbox 
        wire:model="remember" 
        id="remember"
    />
</div>
```

### Conditional Checkbox
```blade
<x-cube::checkbox 
    wire:model="premium_features" 
    :disabled="!$user->hasSubscription()"
    @if($user->isMinor()) :checked="false" @endif
>
    Enable premium features
</x-cube::checkbox>
```

### Checkbox with Custom ID and Attributes
```blade
<x-cube::checkbox 
    wire:model="newsletter" 
    id="newsletter-subscription"
    aria-label="Subscribe to newsletter"
    data-track="newsletter-checkbox"
>
    Subscribe to our newsletter
</x-cube::checkbox>
```

## Form Integration Examples

### Login Form
```blade
<form wire:submit="login">
    <div class="space-y-4">
        <!-- Email Input -->
        <x-cube::group name="email" label="Email Address" required>
            <x-cube::input 
                type="email" 
                wire:model="email" 
                required 
            />
        </x-cube::group>
        
        <!-- Password Input -->
        <x-cube::group name="password" label="Password" required>
            <x-cube::input 
                type="password" 
                wire:model="password" 
                required 
            />
        </x-cube::group>
        
        <!-- Remember Me Checkbox -->
        <x-cube::checkbox wire:model="remember">
            Remember me
        </x-cube::checkbox>
        
        <!-- Submit Button -->
        <x-cube::button type="submit" variant="primary">
            Login
        </x-cube::button>
    </div>
</form>
```

### Registration Form
```blade
<form wire:submit="register">
    <div class="space-y-4">
        <!-- Name Input -->
        <x-cube::group name="name" label="Full Name" required>
            <x-cube::input 
                type="text" 
                wire:model="name" 
                required 
            />
        </x-cube::group>
        
        <!-- Email Input -->
        <x-cube::group name="email" label="Email Address" required>
            <x-cube::input 
                type="email" 
                wire:model="email" 
                required 
            />
        </xube::group>
        
        <!-- Password Input -->
        <x-cube::group name="password" label="Password" required>
            <x-cube::input 
                type="password" 
                wire:model="password" 
                required 
            />
        </x-cube::group>
        
        <!-- Terms Checkbox -->
        <div class="space-y-2">
            <x-cube::checkbox 
                wire:model="terms" 
                required
            >
                I agree to the 
                <a href="/terms" class="text-blue-600 hover:underline">
                    Terms and Conditions
                </a>
            </x-cube::checkbox>
            <x-cube::error :messages="$errors->get('terms')" />
        </div>
        
        <!-- Newsletter Checkbox -->
        <x-cube::checkbox wire:model="newsletter">
            Subscribe to our newsletter for updates
        </x-cube::checkbox>
        
        <!-- Submit Button -->
        <x-cube::button type="submit" variant="primary">
            Create Account
        </x-cube::button>
    </div>
</form>
```

### Settings Form
```blade
<form wire:submit="updateSettings">
    <div class="space-y-6">
        <h2 class="text-xl font-semibold">Notification Settings</h2>
        
        <!-- Email Notifications -->
        <div class="space-y-2">
            <x-cube::checkbox wire:model="email_notifications">
                Receive email notifications
            </x-cube::checkbox>
        </div>
        
        <!-- SMS Notifications -->
        <div class="space-y-2">
            <x-cube::checkbox 
                wire:model="sms_notifications" 
                :disabled="!$user->hasVerifiedPhone()"
            >
                Receive SMS notifications
            </x-cube::checkbox>
            @if(!$user->hasVerifiedPhone())
                <p class="text-sm text-gray-500">
                    Verify your phone number to enable SMS notifications
                </p>
            @endif
        </div>
        
        <!-- Marketing Emails -->
        <div class="space-y-2">
            <x-cube::checkbox wire:model="marketing_emails">
                Receive marketing emails and offers
            </x-cube::checkbox>
        </div>
        
        <!-- Daily Digest -->
        <div class="space-y-2">
            <x-cube::checkbox wire:model="daily_digest">
                Receive daily digest of activity
            </x-cube::checkbox>
        </div>
        
        <!-- Save Button -->
        <x-cube::button type="submit" variant="primary">
            Save Settings
        </x-cube::button>
    </div>
</form>
```

## Livewire Component Examples

### Livewire Component Class
```php
<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UserPreferences extends Component
{
    public $remember = false;
    public $newsletter = false;
    public $terms = false;
    public $interests = [];

    protected $rules = [
        'terms' => 'accepted',
        'interests' => 'array|min:1',
    ];

    public function save()
    {
        $this->validate();

        // Save preferences to database
        auth()->user()->update([
            'remember_me' => $this->remember,
            'newsletter' => $this->newsletter,
            'interests' => $this->interests,
        ]);

        session()->flash('message', 'Preferences saved successfully!');
    }

    public function render()
    {
        return view('livewire.user-preferences');
    }
}
```

### Livewire View
```blade
<div>
    <form wire:submit="save">
        <div class="space-y-4">
            <!-- Remember Me -->
            <x-cube::checkbox wire:model="remember">
                Remember my preferences
            </x-cube::checkbox>
            
            <!-- Newsletter -->
            <x-cube::checkbox wire:model="newsletter">
                Subscribe to newsletter
            </x-cube::checkbox>
            
            <!-- Interests -->
            <div class="space-y-2">
                <p class="font-medium">Select your interests:</p>
                
                <x-cube::checkbox wire:model="interests" value="tech">
                    Technology
                </x-cube::checkbox>
                
                <x-cube::checkbox wire:model="interests" value="sports">
                    Sports
                </x-cube::checkbox>
                
                <x-cube::checkbox wire:model="interests" value="music">
                    Music
                </x-cube::checkbox>
                
                <x-cube::error :messages="$errors->get('interests')" />
            </div>
            
            <!-- Terms -->
            <div class="space-y-2">
                <x-cube::checkbox wire:model="terms" required>
                    I agree to the terms and conditions
                </x-cube::checkbox>
                <x-cube::error :messages="$errors->get('terms')" />
            </div>
            
            <!-- Submit -->
            <x-cube::button type="submit" variant="primary">
                Save Preferences
            </x-cube::button>
        </div>
        
        @if(session()->has('message'))
            <div class="mt-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif
    </form>
</div>
```

## Styling Customization Examples

### Custom Classes
```blade
<x-cube::checkbox 
    wire:model="remember"
    class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
>
    Remember me
</x-cube::checkbox>
```

### Dark Mode Customization
```blade
<x-cube::checkbox 
    wire:model="remember"
    class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-indigo-600 dark:focus:ring-indigo-600"
>
    Remember me
</x-cube::checkbox>
```

## Accessibility Examples

### With ARIA Labels
```blade
<x-cube::checkbox 
    wire:model="terms"
    aria-label="Accept terms and conditions"
    aria-describedby="terms-description"
>
    I agree to the terms and conditions
</x-cube::checkbox>

<p id="terms-description" class="text-sm text-gray-600">
    By checking this box, you agree to our terms of service and privacy policy.
</p>
```

### With Custom Label Association
```blade
<label for="custom-checkbox" class="block mb-2 font-medium">
    Custom Label
</label>

<x-cube::checkbox 
    wire:model="custom_field"
    id="custom-checkbox"
>
    Checkbox description
</x-cube::checkbox>
```

## Migration from Old Component

### Before (Old Component)
```blade
<x-frontend.form.checkbox 
    name="remember"
    label="Remember me"
    :checked="true"
    :disabled="false"
    :required="false"
/>
```

### After (Laravel-Cube)
```blade
<x-cube::checkbox 
    wire:model="remember"
    :checked="true"
>Remember me</x-cube::checkbox>
```

## Common Patterns

### Toggle All Checkboxes
```blade
<div class="space-y-2">
    <!-- Select All -->
    <x-cube::checkbox 
        wire:model="selectAll" 
        wire:click="$toggle('selectAll')"
    >
        Select All
    </x-cube::checkbox>
    
    <!-- Individual Items -->
    @foreach($items as $item)
        <x-cube::checkbox 
            wire:model="selectedItems" 
            value="{{ $item->id }}"
        >
            {{ $item->name }}
        </x-cube::checkbox>
    @endforeach
</div>
```

### Dependent Checkboxes
```blade
<div class="space-y-2">
    <!-- Parent Checkbox -->
    <x-cube::checkbox wire:model="enableNotifications">
        Enable Notifications
    </x-cube::checkbox>
    
    <!-- Child Checkboxes (shown only when parent is checked) -->
    @if($enableNotifications)
        <div class="ml-4 space-y-2">
            <x-cube::checkbox wire:model="emailNotifications">
                Email Notifications
            </x-cube::checkbox>
            
            <x-cube::checkbox wire:model="smsNotifications">
                SMS Notifications
            </x-cube::checkbox>
        </div>
    @endif
</div>
```

## Tips and Best Practices

1. **Always use wire:model for Livewire components**
2. **Provide clear, descriptive labels**
3. **Use the required attribute for mandatory checkboxes**
4. **Add error display for validation feedback**
5. **Use disabled state for non-editable checkboxes**
6. **Test with keyboard navigation**
7. **Ensure sufficient color contrast**
8. **Use semantic HTML structure**
9. **Consider mobile touch targets**
10. **Test with screen readers for accessibility**
