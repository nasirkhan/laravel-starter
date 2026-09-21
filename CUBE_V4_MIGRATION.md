# laravel-cube v4 Migration Notes

## What Changed

laravel-cube v4 drops Bootstrap support and migrates all components from class-based to **anonymous Blade components**, enabling full compatibility with [Livewire Blaze](https://github.com/livewire/blaze) for significantly faster component rendering.

## Breaking Changes

### Bootstrap removed
The `framework` prop and Bootstrap variant of every component no longer exist. Remove any per-component or global Bootstrap configuration:

```php
// config/cube.php — remove these
'default_framework' => 'bootstrap',
'bootstrap' => [...],
```

```blade
{{-- Remove framework prop from all usages --}}
<x-cube::button framework="bootstrap">...</x-cube::button>
```

### Class-based components replaced
If you published and extended any `Nasirkhan\LaravelCube\View\Components\*` PHP classes, those classes are gone. Anonymous components cannot be extended via PHP inheritance.

### `CastsBooleans` / boolean string coercion removed
v3 accepted `"true"` / `"false"` strings for boolean props. v4 uses standard Blade `@props` defaults — pass real PHP booleans or omit the prop entirely:

```blade
{{-- v3 --}}
<x-cube::input disabled="true" />

{{-- v4 --}}
<x-cube::input disabled />
```

### `RendersWithFallback` error boundary removed
Failed component renders now surface as standard Laravel exceptions instead of falling back to a silent error boundary view.

### Config-driven CSS classes removed
The `cube.tailwind.*` config keys for customizing component classes no longer exist. Customize components by publishing the blade views instead:

```bash
php artisan vendor:publish --tag=cube-views
```

## New: Blaze Support

Install Blaze to enable automatic component pre-compilation:

```bash
composer require livewire/blaze
php artisan view:clear
```

No further configuration needed — all eligible cube components are pre-compiled automatically. Components with dynamic per-request data (auth, session, CSRF) will not be folded at compile time.

Register `@blaze` as a no-op if you use cube components in a project without Blaze installed — the `CubeServiceProvider` handles this automatically.

## Upgrade Steps

1. Remove Bootstrap-related config from `config/cube.php`
2. Remove `framework="bootstrap"` props from all blade usages
3. Replace `disabled="true"` string booleans with `disabled` attribute syntax
4. Delete any extended PHP component classes that inherit from cube's v3 classes
5. Re-publish views if you had previously published and customized them
6. Run `php artisan view:clear`
7. Optionally install `livewire/blaze` for performance gains
8. Check the Laravel-starter project for any remaining Bootstrap-specific code or class-based component usages and update them accordingly.
9. Check and update any custom Blade directives or helper functions that may rely on the old Bootstrap framework.
10. Check and update Laravel-admin package for any Bootstrap-specific code or class-based component usages and update them accordingly.
11. Check and update any other packages (module-manager, laravel-jodit, laravel-sharekit) or custom code that may rely on the old Bootstrap framework.
