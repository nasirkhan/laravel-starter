# Checkbox Component Migration - Quick Reference

## TL;DR

**Yes, the checkbox component CAN be replaced with laravel-cube package components.**

The laravel-cube package provides a robust, well-maintained checkbox component with dual framework support (Tailwind CSS & Bootstrap 5).

## Quick Migration

### Old Usage
```blade
<x-frontend.form.checkbox 
    name="remember"
    label="Remember me"
    :checked="true"
    :disabled="false"
    :required="false"
/>
```

### New Usage
```blade
<x-cube::checkbox 
    wire:model="remember"
    :checked="true"
>Remember me</x-cube::checkbox>
```

## Key Changes

| Aspect | Old Component | New Component |
|--------|--------------|--------------|
| **Component** | `<x-frontend.form.checkbox>` | `<x-cube::checkbox>` |
| **Label** | Via `label` prop | Via slot content |
| **Name** | Via `name` prop | Via `wire:model` or `name` attribute |
| **Frameworks** | Tailwind only | Tailwind + Bootstrap |
| **Dynamic IDs** | ❌ Hardcoded | ✅ Supported |
| **Error Display** | ❌ None | ✅ Separate component |

## Props Comparison

### Old Component Props
```php
@props([
    "value" => "",
    "name" => $attributes->whereStartsWith("wire:model")->first(),
    "disabled" => false,
    "required" => false,
    "checked" => false,
    "label",
])
```

### New Component Props
```php
public function __construct(
    bool|string $disabled = false,
    bool|string $required = false,
    bool|string $checked = false,
    ?string $framework = null
)
```

## Common Use Cases

### 1. Simple Checkbox
```blade
<x-cube::checkbox wire:model="remember">Remember me</x-cube::checkbox>
```

### 2. Required Checkbox with Error Display
```blade
<x-cube::checkbox wire:model="terms" required>
    I agree to the terms
</x-cube::checkbox>
<x-cube::error :messages="$errors->get('terms')" />
```

### 3. Disabled Checkbox
```blade
<x-cube::checkbox wire:model="option" disabled>
    Disabled option
</x-cube::checkbox>
```

### 4. Pre-checked Checkbox
```blade
<x-cube::checkbox wire:model="newsletter" :checked="true">
    Subscribe to newsletter
</x-cube::checkbox>
```

### 5. Checkbox Group
```blade
@foreach ($options as $option)
    <x-cube::checkbox 
        wire:model="selected" 
        value="{{ $option->id }}"
    >
        {{ $option->name }}
    </x-cube::checkbox>
@endforeach
```

### 6. Bootstrap Framework
```blade
<x-cube::checkbox framework="bootstrap" wire:model="remember">
    Remember me
</x-cube::checkbox>
```

### 7. With Custom ID
```blade
<x-cube::checkbox wire:model="remember" id="custom-id">
    Remember me
</x-cube::checkbox>
```

## Configuration

### Set Default Framework

**Option 1: .env file**
```env
CUBE_FRAMEWORK=tailwind  # or 'bootstrap'
```

**Option 2: Config file**
```bash
php artisan vendor:publish --tag=cube-config
```

Edit `config/cube.php`:
```php
'default_framework' => 'tailwind',
```

### Customize Styles

**Option 1: Publish views**
```bash
php artisan vendor:publish --tag=cube-views
```

Edit `resources/views/vendor/cube/components/forms/checkbox/tailwind.blade.php`

**Option 2: Pass custom classes**
```blade
<x-cube::checkbox 
    wire:model="remember"
    class="custom-checkbox-class"
>Remember me</x-cube::checkbox>
```

## Migration Checklist

- [ ] Review current checkbox usages
- [ ] Set default framework (if needed)
- [ ] Update component syntax
- [ ] Add error display where needed
- [ ] Test wire:model binding
- [ ] Verify checked state
- [ ] Test disabled state
- [ ] Check validation
- [ ] Test dark mode
- [ ] Verify accessibility

## Benefits of Migration

✅ **Better Code Quality**
- Clean attribute handling
- No hardcoded values
- Type-safe props

✅ **Framework Flexibility**
- Switch between Tailwind and Bootstrap
- Per-component framework selection

✅ **Maintainability**
- Package updates
- Bug fixes
- Community support

✅ **Features**
- Dark mode support
- Better accessibility
- Error handling integration

✅ **Consistency**
- Unified API across form components
- Predictable behavior

## Troubleshooting

### Issue: Component not found
**Solution:** Ensure laravel-cube is installed:
```bash
composer require nasirkhan/laravel-cube
```

### Issue: Styles not applying
**Solution:** Check framework configuration:
```bash
php artisan config:clear
php artisan view:clear
```

### Issue: wire:model not working
**Solution:** Ensure Livewire is properly set up and component is in a Livewire context.

### Issue: Labels not showing
**Solution:** Use slot content instead of label prop:
```blade
<!-- Wrong -->
<x-cube::checkbox wire:model="remember" label="Remember me" />

<!-- Correct -->
<x-cube::checkbox wire:model="remember">Remember me</x-cube::checkbox>
```

## Resources

- **Migration Guide:** [`docs/CHECKBOX_MIGRATION_GUIDE.md`](docs/CHECKBOX_MIGRATION_GUIDE.md)
- **Usage Examples:** [`docs/CHECKBOX_EXAMPLES.md`](docs/CHECKBOX_EXAMPLES.md)
- **Package README:** [`vendor/nasirkhan/laravel-cube/README.md`](vendor/nasirkhan/laravel-cube/README.md)
- **Component Source:** [`vendor/nasirkhan/laravel-cube/src/View/Components/Forms/Checkbox.php`](vendor/nasirkhan/laravel-cube/src/View/Components/Forms/Checkbox.php)

## Summary

**The migration is RECOMMENDED** because:

1. ✅ Laravel-cube is already installed in the project
2. ✅ The component is actively maintained
3. ✅ It provides better features and flexibility
4. ✅ It follows Laravel best practices
5. ✅ It supports multiple frameworks
6. ✅ It has better accessibility support
7. ✅ It integrates with error handling
8. ✅ It's type-safe and well-tested

**The migration is STRAIGHTFORWARD**:

1. Change component tag from `<x-frontend.form.checkbox>` to `<x-cube::checkbox>`
2. Move label from prop to slot content
3. Ensure wire:model is properly set
4. Add error display if needed
5. Test thoroughly

**Estimated time:** 1-2 hours for a complete migration (depending on number of usages)
