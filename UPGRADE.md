# Upgrade Guide

This guide provides step-by-step instructions for upgrading between major versions of Laravel Starter.

## Table of Contents
- [General Upgrade Tips](#general-upgrade-tips)
- [Current Version: 12.20.0](#current-version-1220)
- [Future Upgrades](#future-upgrades)
- [Version History](#version-history)

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

3. **Review Module Status**
   ```bash
   php artisan module:status
   ```

4. **Review Error Logs**
   - Check storage/logs for any issues
   - Monitor application behavior

---

## Current Version: 12.20.0

Laravel Starter is currently at version **12.20.0**, based on Laravel 12.x with PHP 8.3 support.

### Key Features in Current Version
- Laravel 12.x framework
- PHP 8.2 support
- Livewire 4.0 integration
- Modular architecture with Backend/Frontend separation
- Role-based permissions (Spatie)
- Social login (Google, Facebook, GitHub)
- Multi-language support (Bengali, English, Farsi, Hindi, Turkish, Vietnamese)
- Log viewer integration
- Dark mode support throughout
- Dynamic menu system
- Activity logging
- Media library
- Automated backups

### What's New in Recent Releases

**v12.20.0** (Latest - January 2026)
- Resolved menu data format conflict
- Various code style improvements
- Enhanced stability

**v12.19.0** (November 2025)
- Code structure refactoring
- Improved readability and maintainability

**v12.18.0** (November 2025)
- Log viewer integration with CoreUI styling
- Enhanced logging capabilities

For complete version history, see [GitHub Releases](https://github.com/nasirkhan/laravel-starter/releases).

---

## Future Upgrades

### Planning for Version 13.x

> **Note:** This section is for future planning when Laravel 13 is released

When upgrading to a future major version (e.g., 13.x), the following changes are planned:

#### Planned Module System Enhancement

**Current (12.x):**
```php
// Modules in Modules/ directory (current approach)
use Modules\Post\Models\Post;
use Modules\Post\Http\Controllers\PostController;
```

**Future (13.x - Planned):**
```php
// Modules in vendor by default (updateable via composer)
use Nasirkhan\ModuleManager\Modules\Post\Models\Post;
use Nasirkhan\ModuleManager\Modules\Post\Http\Controllers\PostController;

// Or if published to Modules/ for customization:
use Modules\Post\Models\Post;
use Modules\Post\Http\Controllers\PostController;
```

This approach will allow:
- Package modules updateable via `composer update`
- Selective customization by publishing specific modules
- Clear separation between package code and custom code
- Native Laravel override patterns

#### Upgrade Process (When 13.x is Released)

**Step 1: Check Module Status**

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

**Step 2: Update Dependencies**
```bash
composer update
npm install && npm run build
```

**Step 3: Test Thoroughly**
```bash
php artisan test
```

---

## Version History

### What Changed Between Versions

For detailed version history and changelogs, see:
- [CHANGELOG.md](CHANGELOG.md) - Comprehensive change log
- [GitHub Releases](https://github.com/nasirkhan/laravel-starter/releases) - Official releases

### Major Milestones

**v12.x Series** (2025-2026)
- Laravel 12.x support
- PHP 8.3 support  
- Livewire 4.0 integration
- Enhanced modular architecture
- Log viewer integration
- Continuous improvements and bug fixes

**v11.x Series** (2024-2025)
- Laravel 11.x support
- Initial Livewire 4 adoption
- Module system enhancements

**Earlier Versions**
- See [GitHub Releases](https://github.com/nasirkhan/laravel-starter/releases) for complete history

---

## Getting Help

- **Documentation:** Check [docs/](docs/) folder
- **Issues:** [GitHub Issues](https://github.com/nasirkhan/laravel-starter/issues)
- **Discussions:** [GitHub Discussions](https://github.com/nasirkhan/laravel-starter/discussions)

---

## Contributing

Found an issue with this upgrade guide? Submit a PR to improve it!

See [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.
