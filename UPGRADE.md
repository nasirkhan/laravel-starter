# Upgrade Guide

This guide provides step-by-step instructions for upgrading between major versions of Laravel Starter.

## Table of Contents
- [General Upgrade Tips](#general-upgrade-tips)
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
