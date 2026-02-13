# Checkbox Component Migration Guide

## Overview

This guide explains how to replace the custom checkbox component at `resources/views/components/frontend/form/checkbox.blade.php` with the laravel-cube package's `<x-cube::checkbox>` component.

## Why Migrate?

### Current Component Issues
1. **Hardcoded ID**: `id="checkbox-2"` - not dynamic, causes conflicts
2. **Unused variables**: `$field_lable` defined but never used
3. **Duplicate wire:model**: Specified both explicitly and via attributes
4. **Fixed styling**: No framework flexibility (Tailwind only)
5. **Missing error handling**: No validation error display
6. **Code duplication**: Similar patterns across form components

### Laravel-Cube Benefits
1. **Dual framework support**: Tailwind CSS or Bootstrap 5
2. **Clean attribute handling**: Proper use of `$attributes->merge()`
3. **Slot-based labels**: More flexible label system
4. **Dark mode support**: Built-in dark mode classes
5. **Configurable**: Styles customizable via `config/cube.php`
6. **Type-safe**: Proper boolean handling with `filter_var()`
7. **Well-maintained**: Part of an actively developed package

## Current Component Analysis

### File Location
`resources/views/components/frontend/form/checkbox.blade.php`

### Current Usage Pattern
```blade
<x-frontend.form.checkbox 
    name="remember"
    label="Remember me"
    :checked="true"
    :disabled="false"
    :required="false"
/>
```

### Current Props
- `value`: Default ""
- `name`: Extracted from `wire:model` attribute
- `disabled`: Default false
- `required`: Default false
- `checked`: Default false
- `label`: Required

## Laravel-Cube Checkbox Component

### Component Location
`vendor/nasirkhan/laravel-cube/src/View/Components/Forms/Checkbox.php`

### Available Props
- `disabled`: bool|string (default: false)
- `required`: bool|string (default: false)
- `checked`: bool|string (default: false)
- `framework`: string (default: null, uses config)

### Usage Examples

#### Basic Usage (Tailwind - Default)
```blade
<x-cube::checkbox name="remember">Remember me</x-cube::checkbox>
```

#### With Wire Model
```blade
<x-cube::checkbox 
    wire:model="remember" 
    :checked="true"
>Remember me</x-cube::checkbox>
```

#### With Required Attribute
```blade
<x-cube::checkbox 
    name="terms" 
    required
>I agree to the terms</x-cube::checkbox>
```

#### With Disabled State
```blade
<x-cube::checkbox 
    name="disabled_option" 
    disabled
>Disabled option</x-cube::checkbox>
```

#### Bootstrap Framework
```blade
<x-cube::checkbox 
    framework="bootstrap" 
    name="remember"
>Remember me</x-cube::checkbox>
```

#### With Custom ID
```blade
<x-cube::checkbox 
    name="remember" 
    id="custom-checkbox-id"
>Remember me</x-cube::checkbox>
```

## Migration Steps

### Step 1: Configure Framework (Optional)

Add to `.env` file:
```env
CUBE_FRAMEWORK=tailwind  # or 'bootstrap'
```

Or publish config:
```bash
php artisan vendor:publish --tag=cube-config
```

Then edit `config/cube.php`:
```php
'default_framework' => env('CUBE_FRAMEWORK', 'tailwind'),
```

### Step 2: Update Component Usage

**Before (Current):**
```blade
<x-frontend.form.checkbox 
    name="remember"
    label="Remember me"
    :checked="true"
    :disabled="false"
    :required="false"
/>
```

**After (Laravel-Cube):**
```blade
<x-cube::checkbox 
    wire:model="remember"
    :checked="true"
>Remember me</x-cube::checkbox>
```

### Step 3: Handle Error Display

The current component doesn't display errors. With laravel-cube, you can add error handling:

```blade
<x-cube::checkbox 
    wire:model="remember"
    :checked="true"
>Remember me</x-cube::checkbox>

<x-cube::error :messages="$errors->get('remember')" />
```

### Step 4: Update All Usages

Search for all usages of the old component:
```bash
grep -r "frontend.form.checkbox" resources/views
```

Replace each occurrence with the new component syntax.

## Comparison Table

| Feature | Current Component | Laravel-Cube |
|---------|------------------|--------------|
| Framework Support | Tailwind only | Tailwind + Bootstrap |
| Dynamic IDs | ❌ Hardcoded "checkbox-2" | ✅ Supports custom IDs |
| Label Handling | Via `label` prop | Via slot content |
| Wire Model | ✅ Supported | ✅ Supported |
| Dark Mode | ✅ Manual classes | ✅ Built-in support |
| Error Handling | ❌ None | ✅ Separate component |
| Configurability | ❌ None | ✅ Config-based |
| Type Safety | ❌ Basic | ✅ `filter_var()` |
| Accessibility | ⚠️ Basic | ✅ Better ARIA support |
| Maintenance | Manual | Package updates |

## Styling Customization

### Option 1: Publish Views
```bash
php artisan vendor:publish --tag=cube-views
```

Edit `resources/views/vendor/cube/components/forms/checkbox/tailwind.blade.php`

### Option 2: Override via Config
```bash
php artisan vendor:publish --tag=cube-config
```

Edit `config/cube.php`:
```php
'tailwind' => [
    'forms' => [
        'checkbox' => 'rounded border-gray-300 text-indigo-600...',
    ],
],
```

### Option 3: Pass Custom Classes
```blade
<x-cube::checkbox 
    name="remember"
    class="custom-checkbox-class"
>Remember me</x-cube::checkbox>
```

## Advanced Usage

### Grouped Checkboxes
```blade
@foreach ($options as $option)
    <x-cube::checkbox 
        wire:model="selected_options" 
        value="{{ $option->id }}"
    >
        {{ $option->name }}
    </x-cube::checkbox>
@endforeach
```

### Conditional Rendering
```blade
<x-cube::checkbox 
    wire:model="terms_accepted" 
    :required="true"
    @if($user->isMinor()) disabled @endif
>
    I agree to the terms
</x-cube::checkbox>
```

### With Label Component
```blade
<div class="space-y-2">
    <x-cube::label for="remember" required>Remember me</x-cube::label>
    <x-cube::checkbox 
        wire:model="remember" 
        id="remember"
    />
</div>
```

## Testing Checklist

- [ ] Verify checkbox renders correctly
- [ ] Test wire:model binding
- [ ] Check checked state works
- [ ] Test disabled state
- [ ] Verify required validation
- [ ] Test with custom IDs
- [ ] Check dark mode styling
- [ ] Verify error display
- [ ] Test Bootstrap framework (if applicable)
- [ ] Check mobile responsiveness

## Rollback Plan

If issues arise, you can quickly rollback by:

1. Restore the original component file
2. Revert blade template changes
3. Clear view cache: `php artisan view:clear`

## Additional Resources

- [Laravel-Cube README](vendor/nasirkhan/laravel-cube/README.md)
- [Laravel-Cube Quick Start](vendor/nasirkhan/laravel-cube/QUICK_START.md)
- [Component Source Code](vendor/nasirkhan/laravel-cube/src/View/Components/Forms/Checkbox.php)
- [Tailwind View Template](vendor/nasirkhan/laravel-cube/resources/views/components/forms/checkbox/tailwind.blade.php)
- [Bootstrap View Template](vendor/nasirkhan/laravel-cube/resources/views/components/forms/checkbox/bootstrap.blade.php)

## Conclusion

Migrating to laravel-cube's checkbox component provides:
- ✅ Better code maintainability
- ✅ Framework flexibility
- ✅ Improved accessibility
- ✅ Active package maintenance
- ✅ Consistent component API across forms

The migration is straightforward and provides significant benefits for long-term maintainability.
