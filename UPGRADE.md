# Upgrade Guide

This guide provides step-by-step instructions for upgrading between major versions of Laravel Starter.

## Table of Contents
- [General Upgrade Tips](#general-upgrade-tips)
- [Upgrading to Livewire 4.0 SFC](#upgrading-to-livewire-40-sfc)
- [Upgrading to 13.0 from 12.x](#upgrading-to-130-from-12x)
- [Upgrading to 12.20.0 from 2.x](#upgrading-to-12200-from-2x)

---

## General Upgrade Tips

### Before Upgrading

1. **Backup Everything**
   ```bash
   # Backup database
   php artisan backup:run
   
   # Commit your changes
   git add -A
   git commit -m "Backup before upgrade"
   ```

2. **Review Documentation**
   - Read [CHANGELOG.md](CHANGELOG.md) for all changes
   - Check this upgrade guide for version-specific steps
   - Review breaking changes carefully

3. **Test Environment First**
   - Always upgrade in development/staging first
   - Run full test suite
   - Test critical user flows manually

### After Upgrading

1. **Clear Caches**
   ```bash
   php artisan view:clear
   php artisan config:clear
   php artisan route:clear
   php artisan cache:clear
   ```

2. **Run Tests**
   ```bash
   php artisan test
   ```

3. **Review Error Logs**
   - Check storage/logs for any issues
   - Monitor application behavior

---

## Upgrading to Livewire 4.0 SFC

> **Estimated Time:** 1-2 hours per component  
> **Difficulty:** Low to Medium  
> **Risk Level:** Low (with proper testing)

### Overview

Livewire 4.0 introduces native Single-File Components (SFC) that allow you to define a component's logic and template in a single `.blade.php` file using the `new class extends Component` syntax.

### Requirements

- PHP 8.2 or higher
- Livewire 4.0 or higher
- Laravel 12.x

### What's New in Livewire 4.0 SFC

#### 1. Native SFC Syntax

Livewire 4.0 provides native SFC support without requiring Laravel Volt:

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

#### 2. Emoji File Prefixes

The `make:livewire` command now adds emoji prefixes to component files for better visual organization:

| Component Type | Emoji Prefix | Example |
|---------------|---------------|----------|
| Pages | ⚡ | `⚡ terms.blade.php` |
| Forms | 📝 | `📝 contact.blade.php` |
| Tables | 📊 | `📊 users.blade.php` |
| Cards | 🃏 | `🃏 profile.blade.php` |
| Modals | 🪟 | `🪟 confirm.blade.php` |

#### 3. Configuration Changes

The `config/livewire.php` file has been updated to support SFC:

```php
'make_command' => [
    // 'type' => 'class',  // Match v3 behavior (not SFC)
    'emoji' => true,        // Add emoji prefixes to file names
],
```

### Migration Steps

#### Step 1: Update Livewire

```bash
# Update Livewire to version 4.0
composer update livewire/livewire

# Clear caches
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

#### Step 2: Review Configuration

Ensure your `config/livewire.php` has the correct settings:

```php
'make_command' => [
    'emoji' => true,  // Enable emoji prefixes
],

'component_locations' => [
    resource_path('views/components'),
    resource_path('views/livewire'),
],
```

#### Step 3: Migrate Components One by One

**For each component you want to migrate to SFC:**

1. **Identify the component**
   - Find the PHP class file (e.g., `app/Livewire/Frontend/Terms.php`)
   - Find the Blade view file (e.g., `resources/views/livewire/frontend/terms.blade.php`)

2. **Create the SFC file**
   - Create a new `.blade.php` file in the appropriate directory
   - Use the emoji prefix (e.g., `⚡ terms.blade.php`)

3. **Convert the component**

**Before (Traditional):**

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

**After (SFC):**

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

4. **Delete old files**
   - Remove the PHP class file
   - Remove the old Blade view file

5. **Test the component**
   - Visit the page that uses the component
   - Verify all functionality works correctly

#### Step 4: Update Routes (If Needed)

Routes typically don't need to change, but verify they still work:

```php
// Before
Route::livewire('terms', \App\Livewire\Frontend\Terms::class)->name('terms');

// After - Livewire auto-discovers SFC files
Route::livewire('terms', 'frontend.⚡ terms')->name('terms');
// Or just use the component name without emoji
Route::livewire('terms', 'frontend.terms')->name('terms');
```

#### Step 5: Update Tests

Update test references to use the new component format:

```php
// Before
Livewire::test(\App\Livewire\Frontend\Terms::class)

// After
Livewire::test('frontend.terms')
// Or
Livewire::test('frontend.⚡ terms')
```

### Breaking Changes

#### 1. Class-Based Components Still Work

Traditional class-based components (separate PHP and Blade files) continue to work in Livewire 4.0. You don't have to migrate all components at once.

#### 2. Namespace Changes

SFC components don't use namespaces. The component is defined inline:

```php
// Before - Class-based
namespace App\Livewire\Frontend;
class Terms extends Component { }

// After - SFC
new class extends Component { }
```

#### 3. Render Method Changes

In SFC, the `render()` method is optional and typically just returns:

```php
// Before
public function render()
{
    return view('livewire.frontend.terms', compact('title'));
}

// After - SFC (optional)
public function render()
{
    return;  // Just return void or omit the method
}
```

### Recommended Migration Order

Migrate components in this order to minimize risk:

1. **Simple static components** (Terms, Privacy, Home)
2. **Form components** (Login, Register, ForgotPassword)
3. **List components** (UsersIndex, PostsIndex)
4. **Complex components** (ProfileEdit, PostEdit)

### Troubleshooting

#### Component Not Found

```bash
# Clear view cache
php artisan view:clear

# Clear config cache
php artisan config:clear

# Verify component location
ls resources/views/livewire/frontend/
```

#### Route Not Working

```bash
# Clear route cache
php artisan route:clear

# Check route list
php artisan route:list
```

#### Validation Errors

Ensure you're using the correct attribute syntax:

```php
// Correct
#[Validate('required|string|max:255')]
public $name = '';

// Incorrect
public $name = '';  // Missing validation attribute
```

### Rollback

If you need to rollback a component migration:

```bash
# Restore from git
git checkout app/Livewire/Frontend/Terms.php
git checkout resources/views/livewire/frontend/terms.blade.php

# Delete the SFC file
rm resources/views/livewire/frontend/⚡ terms.blade.php

# Clear caches
php artisan view:clear
php artisan cache:clear
```

### Additional Resources

- [Official Livewire v4 Documentation](https://livewire.laravel.com/docs/4.x/single-file-components)
- [Livewire v4 Upgrade Guide](https://livewire.laravel.com/docs/4.x/upgrade)
- [Project SFC Documentation](docs/SINGLE_FILE_COMPONENTS.md)

---

## Upgrading to 13.0 from 12.x

> **Estimated Time:** TBD  
> **Difficulty:** TBD  
> **Risk Level:** TBD

**Note:** Version 13.0.0 is planned for future release. This section will be updated when v13.0.0 is ready.

---

## Upgrading to 12.20.0 from 2.x

> **Estimated Time:** 30-60 minutes  
> **Difficulty:** Medium  
> **Risk Level:** Low (with proper testing)

### Requirements

- PHP 8.3 or higher
- Laravel 12.x
- Composer 2.0 or higher
- Node.js 18+ and NPM 9+

### High Impact Changes

#### 1. Module System Refactored to Package-Based Architecture

**Before (2.x):**
```php
// Modules always in Modules/ directory
use Modules\Post\Models\Post;
use Modules\Post\Http\Controllers\PostController;
```

**After (12.20.0):**
```php
// Modules in vendor by default (updateable via composer)
use Nasirkhan\ModuleManager\Modules\Post\Models\Post;
use Nasirkhan\ModuleManager\Modules\Post\Http\Controllers\PostController;

// Or if published to Modules/ for customization:
use Modules\Post\Models\Post;
use Modules\Post\Http\Controllers\PostController;
```

#### 2. Configuration Publishing System Introduced

Configuration files can now be published separately from modules.

#### 3. View Override Pattern Changed

Views now follow Laravel's native vendor override pattern.

### Step-by-Step Upgrade Process

#### Step 1: Update Dependencies

```bash
# Update composer dependencies
composer update nasirkhan/module-manager

# Clear all caches
php artisan clear-all
```

#### Step 2: Check Module Status

```bash
# See which modules you have and their status
php artisan module:status
```

**Output will show:**
```
Module     Location           Customized    Update Strategy
Post       vendor (package)   ✓ No          Updateable via composer
Category   Modules/ (custom)  ⚠ Yes         User owns this
Tag        vendor (package)   ✓ No          Updateable via composer
Menu       Modules/ (custom)  ⚠ Yes         User owns this
```

#### Step 3: Handle Customized Modules

For any modules you've customized, check what changed:

```bash
php artisan module:diff Post
php artisan module:diff Category
php artisan module:diff Tag
php artisan module:diff Menu
```

**Review the differences and decide:**
- Merge package updates manually
- Keep your customizations
- Or re-publish and re-apply customizations

#### Step 4: Update Namespaces (If Needed)

If you moved modules from `Modules/` to vendor packages:

**Find and replace in your codebase:**
```bash
# Example: Update Post module references
Modules\Post\  →  Nasirkhan\ModuleManager\Modules\Post\
```

**Or**, if you want to keep using custom modules:
```bash
# Publish the module to Modules/ directory
php artisan module:publish Post
```

#### Step 5: Publish New Configuration

```bash
# Publish module-manager configuration
php artisan vendor:publish --tag=module-manager-config

# Review and update config/module-manager.php if needed
```

#### Step 6: Check for New Migrations

```bash
# Check if packages have new migrations
php artisan module:check-migrations

# Publish new migrations if found
php artisan vendor:publish --tag=post-migrations
php artisan vendor:publish --tag=category-migrations

# Run migrations
php artisan migrate
```

#### Step 7: Update Frontend Assets

```bash
# Reinstall npm packages
npm install

# Rebuild assets
npm run build
```

#### Step 8: Run Tests

```bash
# Run full test suite
php artisan test

# If tests fail, review error messages and update accordingly
```

#### Step 9: Update Custom Code

Review and update any custom code that extends module classes:

**Example:**
```php
// If you extended PostController
// app/Http/Controllers/CustomPostController.php

namespace App\Http\Controllers;

// Update import
use Nasirkhan\ModuleManager\Modules\Post\Http\Controllers\PostController as BaseController;

class CustomPostController extends BaseController
{
    // Your customizations
}
```

### Breaking Changes

#### Module Resolution

**Impact:** High if you have deep integration with modules

**What Changed:**
- Default module location changed from `Modules/` to vendor package
- Namespace changed for package modules
- Module autoloading follows Laravel's package pattern

**Migration:**
```php
// Old way (3.x)
use Modules\Post\Models\Post;

// New way (4.x) - Package modules
use Nasirkhan\ModuleManager\Modules\Post\Models\Post;

// Or publish module and keep old namespace
php artisan module:publish Post
use Modules\Post\Models\Post;  // Still works!
```

#### View Resolution

**Impact:** Low - Laravel handles this automatically

**What Changed:**
- Views now use Laravel's native vendor override system
- Package views automatically check `resources/views/vendor/{package}/` first

**Migration:**
```bash
# To customize views, publish them
php artisan vendor:publish --tag=post-views

# Edit in: resources/views/vendor/post/index.blade.php
# Laravel automatically uses your version
```

#### Configuration Merging

**Impact:** Low

**What Changed:**
- Module configs now use `mergeConfigFrom()`
- Published configs override package defaults

**Migration:**
```bash
# Publish config to customize
php artisan vendor:publish --tag=post-config

# Edit: config/post.php
# Your values automatically override package defaults
```

### Medium Impact Changes

#### Service Provider Registration

**What Changed:**
- Module service providers auto-register from vendor
- Published modules use existing registration

**Action Required:**
- None if using default setup
- If customized, ensure providers are registered in `bootstrap/providers.php`

### Low Impact Changes

#### Command Signatures

**What Changed:**
- New commands added: `module:publish`, `module:status`, `module:diff`, `module:check-migrations`

**Action Required:**
- None - new functionality is additive

### Troubleshooting

#### "Class not found" Errors

```bash
# Run composer dump-autoload
composer dump-autoload

# Clear cache
php artisan clear-all
```

#### Views Not Loading

```bash
# Clear view cache
php artisan view:clear

# Verify view paths
php artisan about
```

#### Modules Not Showing in Status

```bash
# Ensure package is installed
composer require nasirkhan/module-manager

# Check vendor/nasirkhan/module-manager/src/Modules/ exists
```

### Rollback Instructions

If you need to rollback:

```bash
# Restore from git
git reset --hard HEAD~1

# Or restore database backup
# Restore files from backup
```

---

## Legacy Information

> **Note:** For upgrades from very old versions (pre-2.x), please consult the project's Git history or contact support.

---

## Getting Help

- **Documentation:** Check [docs/](docs/) folder
- **Issues:** [GitHub Issues](https://github.com/nasirkhan/laravel-starter/issues)
- **Discussions:** [GitHub Discussions](https://github.com/nasirkhan/laravel-starter/discussions)

---

## Contributing

Found an issue with this upgrade guide? Submit a PR to improve it!

See [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.
