# IDE Helper Setup

**Last Updated:** February 3, 2026

This guide explains how to use IDE helper files for better code completion and type hinting in your IDE.

---

## 📋 Table of Contents

1. [Overview](#overview)
2. [Generated Files](#generated-files)
3. [Usage](#usage)
4. [Updating Helper Files](#updating-helper-files)
5. [IDE Configuration](#ide-configuration)
6. [Troubleshooting](#troubleshooting)

---

## Overview

Laravel Starter includes [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper) to improve the development experience with better autocomplete, type hinting, and code navigation in popular IDEs.

### Benefits

- ✅ Autocomplete for facades
- ✅ Type hinting for Eloquent models
- ✅ PhpDoc generation for model properties and relationships
- ✅ Better navigation to method definitions
- ✅ Reduced "undefined method" warnings

---

## Generated Files

Three helper files are automatically generated:

### 1. `_ide_helper.php`
Contains PHPDoc definitions for Laravel facades and helper functions.

```php
/**
 * @see \Illuminate\Support\Facades\Route
 */
class Route extends \Illuminate\Support\Facades\Route {}
```

### 2. `_ide_helper_models.php`
Contains PHPDoc blocks for Eloquent models with properties and relationships.

```php
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 */
class User extends \Eloquent {}
```

### 3. `.phpstorm.meta.php`
PhpStorm-specific metadata for better code completion.

---

## Usage

### Automatic Generation

IDE helper files are automatically generated:

1. **After `composer update`**:
```bash
composer update
# Automatically runs: ide-helper:generate and ide-helper:meta
```

2. **Manual generation**:
```bash
# Generate all helper files
composer ide-helper

# Or individually:
php artisan ide-helper:generate        # Facades
php artisan ide-helper:models -N       # Models (no interaction)
php artisan ide-helper:meta            # PhpStorm meta
```

### When to Regenerate

Regenerate helper files when you:
- Add new models
- Add new relationships to models
- Add new custom facades
- Update model properties
- Install new packages with facades

---

## Updating Helper Files

### After Model Changes

When you create or modify models:

```bash
# Regenerate model helpers
php artisan ide-helper:models -N
```

**Without `-N` flag** (interactive mode):
- Allows you to write PHPDoc directly to model files
- More intrusive but better for some workflows

```bash
php artisan ide-helper:models
# Asks: Do you want to overwrite the existing model files?
```

### After Adding New Packages

When you add packages with facades:

```bash
composer update
# Automatically regenerates facades helper
```

Or manually:
```bash
php artisan ide-helper:generate
```

---

## IDE Configuration

### PhpStorm / IntelliJ IDEA

**Already Configured!** No additional setup needed.

The `.phpstorm.meta.php` file is automatically recognized.

#### Optional: Mark Helper Files as Plain Text

To reduce indexing time:

1. Right-click `_ide_helper.php`
2. Select **Mark as Plain Text**
3. Repeat for `_ide_helper_models.php`

### VS Code

Install the recommended extensions:

1. **PHP Intelephense**:
```bash
code --install-extension bmewburn.vscode-intelephense-client
```

2. **Laravel Extra Intellisense**:
```bash
code --install-extension amiralizadeh9480.laravel-extra-intellisense
```

VS Code will automatically use the `_ide_helper.php` file for type hinting.

### Sublime Text

Install **LSP-intelephense** package:

1. Install Package Control
2. Install "LSP" package
3. Install "LSP-intelephense" package
4. Helper files will be automatically indexed

---

## Troubleshooting

### Issue: IDE Not Recognizing Helper Files

**Solution 1: Regenerate files**
```bash
composer ide-helper
```

**Solution 2: Clear IDE cache**
- **PhpStorm**: File → Invalidate Caches → Clear file system cache and Local History
- **VS Code**: Reload window (Ctrl+Shift+P → "Reload Window")

### Issue: Model Properties Not Showing

**Problem**: Added new properties but autocomplete doesn't show them.

**Solution**:
```bash
php artisan ide-helper:models -N
```

### Issue: Duplicate Suggestions

**Problem**: Getting duplicate autocomplete suggestions.

**Solution**: Make sure helper files are excluded from indexing or marked as plain text in your IDE.

### Issue: Helper Files Committed to Git

**Problem**: Helper files accidentally committed.

**Solution**:
```bash
# Remove from Git but keep locally
git rm --cached _ide_helper.php
git rm --cached _ide_helper_models.php
git rm --cached .phpstorm.meta.php

# Verify .gitignore includes:
# _ide_helper.php
# _ide_helper_models.php
# .phpstorm.meta.php
```

### Issue: Out of Memory When Generating

**Problem**: `php artisan ide-helper:models` runs out of memory.

**Solution**:
```bash
# Increase memory limit
php -d memory_limit=512M artisan ide-helper:models -N
```

---

## Advanced Configuration

### Publish Configuration

To customize IDE helper behavior:

```bash
php artisan vendor:publish --provider="Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider" --tag=config
```

Edit `config/ide-helper.php` to customize:

```php
return [
    // Write annotations to model files instead of _ide_helper_models.php
    'write_model_magic_where' => true,
    
    // Include fluent methods in model helper
    'include_fluent' => true,
    
    // Custom model directories
    'model_locations' => [
        'app/Models',
        'app/Modules/*/Models',
    ],
];
```

### CI/CD Integration

Add to your CI pipeline to ensure helpers are up-to-date:

```yaml
# .github/workflows/tests.yml
- name: Generate IDE Helpers
  run: |
    composer ide-helper
    git diff --exit-code _ide_helper.php
```

---

## Best Practices

### Development Workflow

1. **After pulling changes**:
```bash
composer install
# Helpers regenerate automatically
```

2. **After creating models**:
```bash
php artisan make:model MyModel -m
php artisan ide-helper:models -N
```

3. **Before committing**:
```bash
# Ensure helpers are in .gitignore
git status
# Should NOT show helper files
```

### Team Setup

**Add to README.md**:
```markdown
## IDE Setup

After cloning, run:
```bash
composer install
composer ide-helper
```

For PhpStorm users, enable Laravel plugin:
- File → Settings → PHP → Laravel → Enable for this project
```

---

## Resources

### Official Documentation
- [Laravel IDE Helper GitHub](https://github.com/barryvdh/laravel-ide-helper)
- [Laravel IDE Helper Configuration](https://github.com/barryvdh/laravel-ide-helper#configuration)

### IDE-Specific Guides
- [PhpStorm Laravel Plugin](https://plugins.jetbrains.com/plugin/7532-laravel)
- [VS Code PHP Intelephense](https://intelephense.com/)
- [Sublime Text LSP Setup](https://lsp.sublimetext.io/)

---

*This document is part of Laravel Starter. For issues or suggestions, please open an issue on GitHub.*
