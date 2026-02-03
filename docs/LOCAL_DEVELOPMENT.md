# Local Development Setup

When developing both `laravel-starter` and `module-manager` simultaneously:

## Setup Local Package Link

```bash
cd laravel-starter

# Add path repository (DO NOT COMMIT THIS)
composer config repositories.module-manager path ../module-manager

# Install local version
composer require nasirkhan/module-manager:@dev

# Verify it's using local path
composer show nasirkhan/module-manager
# Should show: source : [path] ../module-manager
```

## Before Committing

```bash
# Remove path repository
composer config --unset repositories.module-manager

# Restore to version constraint
composer require nasirkhan/module-manager:^4.0

# Verify
git diff composer.json
# Should show NO changes to repositories section
```

## Quick Toggle Script

### Enable Local Development
```bash
composer config repositories.module-manager path ../module-manager
composer require nasirkhan/module-manager:@dev
```

### Disable Local Development  
```bash
composer config --unset repositories.module-manager
composer require nasirkhan/module-manager:^4.0
composer update nasirkhan/module-manager
```

## Testing Changes

After making changes to module-manager:

```bash
# No need to reinstall, composer path links are live!
# Just clear cache
php artisan clear-all

# Test commands
php artisan module:status
php artisan module:publish Post
```
