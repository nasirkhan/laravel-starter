# Package Migrations & Seeders Management Guide

**Last Updated:** February 10, 2026  
**Status:** Complete

This guide explains how to manage migrations and seeders from the `module-manager` package and other packages.

---

## 📋 Table of Contents

1. [Understanding Package Migrations](#understanding-package-migrations)
2. [Running Package Migrations](#running-package-migrations)
3. [Excluding Package Migrations](#excluding-package-migrations)
4. [Managing Package Seeders](#managing-package-seeders)
5. [Module-Specific Commands](#module-specific-commands)
6. [Troubleshooting](#troubleshooting)

---

## Understanding Package Migrations

The `module-manager` package contains migrations for all modules (Post, Category, Tag, Menu, Backup, FileManager). These migrations are automatically loaded from the package via the service providers.

### Migration Loading

Each module's `ServiceProvider` loads migrations from the package:

```php
// In PostServiceProvider.php
public function boot()
{
    // Load migrations from package
    $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
}
```

### Migration Location

- **Package Migrations:** `module-manager/src/Modules/{Module}/database/migrations/`
- **Published Migrations:** `laravel-starter/database/migrations/` (optional)

---

## Running Package Migrations

### Run All Migrations (Core + Package)

```bash
# Run all pending migrations
php artisan migrate

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Rollback last batch
php artisan migrate:rollback

# Reset all migrations
php artisan migrate:reset
```

### Run Specific Module Migrations

You can run migrations from a specific path:

```bash
# Run only Post module migrations
php artisan migrate --path=vendor/nasirkhan/module-manager/src/Modules/Post/database/migrations

# Run only Category module migrations
php artisan migrate --path=vendor/nasirkhan/module-manager/src/Modules/Category/database/migrations
```

### Check Migration Status

```bash
# List all migrations and their status
php artisan migrate:status

# Check for pending migrations
php artisan module:check-migrations
```

---

## Excluding Package Migrations

### Method 1: Disable Module (Recommended)

Use `modules_statuses.json` to control which modules are loaded:

```json
{
  "Post": true,
  "Category": true,
  "Tag": false,
  "Menu": true,
  "Backup": false,
  "FileManager": true
}
```

Then disable the module:

```bash
php artisan module:disable Tag
php artisan module:disable Backup
```

**Note:** This prevents the module's service provider from loading, which stops migrations from being registered.

### Method 2: Don't Register Service Providers

In `config/app.php` or package discovery, you can exclude specific service providers:

```php
// composer.json extra section
"extra": {
    "laravel": {
        "dont-discover": [
            "nasirkhan/module-manager/TagServiceProvider",
            "nasirkhan/module-manager/BackupServiceProvider"
        ]
    }
}
```

### Method 3: Publish and Delete

Publish migrations to your app, then manage them manually:

```bash
# Publish all Post migrations
php artisan vendor:publish --tag=post-migrations

# Now delete unwanted migrations from database/migrations/
```

### Method 4: Skip Packages in Fresh Migration

```bash
# Only migrate core (exclude vendor packages)
php artisan migrate:fresh --database=mysql --path=database/migrations
```

### Method 5: Environment-Based Control

Create a config file to control package migrations:

```php
// config/modules.php
return [
    'load_migrations' => env('LOAD_MODULE_MIGRATIONS', true),
    
    'enabled_modules' => [
        'Post' => env('MODULE_POST_ENABLED', true),
        'Category' => env('MODULE_CATEGORY_ENABLED', true),
        'Tag' => env('MODULE_TAG_ENABLED', true),
        'Menu' => env('MODULE_MENU_ENABLED', true),
        'Backup' => env('MODULE_BACKUP_ENABLED', false),
        'FileManager' => env('MODULE_FILEMANAGER_ENABLED', true),
    ],
];
```

Then in `.env`:

```env
LOAD_MODULE_MIGRATIONS=true
MODULE_POST_ENABLED=true
MODULE_CATEGORY_ENABLED=true
MODULE_TAG_ENABLED=false
MODULE_MENU_ENABLED=true
MODULE_BACKUP_ENABLED=false
MODULE_FILEMANAGER_ENABLED=true
```

---

## Managing Package Seeders

### Understanding Seeder Registration

Module seeders are registered in the service providers and categorized as either **essential** (mandatory) or **dummy data** (optional):

**Essential Seeders (Always Run):**
- **AuthTableSeeder** - Users, Roles, Permissions (mandatory)
- **Menu Module** - Navigation menus and menu items (mandatory)

**Dummy Data Seeders (Optional):**
- **Category Module** - Sample categories for development
- **Tag Module** - Sample tags for development  
- **Post Module** - Sample blog posts for development

The seeding order is important due to foreign key dependencies:
1. Auth (Users) → Required by all modules
2. Menu → Essential navigation
3. Category → Required by Posts
4. Tag → Required by Posts
5. Post → Depends on Category and Tag

```php
// In PostServiceProvider.php
protected function registerSeeders()
{
    // Register the seeder class name in the container
    $this->app->singleton('post.database.seeder', function () {
        return 'Nasirkhan\\ModuleManager\\Modules\\Post\\database\\seeders\\PostDatabaseSeeder';
    });
}
```

The `DatabaseSeeder` automatically discovers and calls these seeders based on `modules_statuses.json`.

### Run All Seeders

```bash
# Run all seeders (Auth + Menu + dummy data)
php artisan db:seed

# Run with fresh migration
php artisan migrate:fresh --seed

# Skip dummy data (only Auth + Menu)
SEED_DUMMY_DATA=false php artisan db:seed
```

### Seeding Output Example

```
INFO  Seeding database.

Database\Seeders\AuthTableSeeder ......................... DONE  
  - Default Users Created
  - Default Permissions Created  
  - Default Roles Created

Seeding essential modules (Menu)...
Menu Module ............................................. DONE
  - 3 menus created (Top Nav, Footer, Admin Sidebar)
  - 50+ menu items created

Seeding dummy data modules (Category, Tag, Post)...
Category Module ......................................... DONE
Tag Module .............................................. DONE
Post Module ............................................. DONE
  - 10 categories, 15 tags, 20 posts created

Dummy data seeders completed
```

### Run Specific Module Seeders

```bash
# Run only Post module seeder
php artisan db:seed --class='Nasirkhan\ModuleManager\Modules\Post\database\seeders\PostDatabaseSeeder'

# Run only Menu module seeder
php artisan db:seed --class='Nasirkhan\ModuleManager\Modules\Menu\database\seeders\MenuDatabaseSeeder'
```

### Exclude Specific Module Seeders

#### Option 1: Disable Module

```bash
# Disable module (prevents seeder from running)
php artisan module:disable Post
php artisan module:disable Tag

# Now run seeding
php artisan db:seed
```

#### Option 2: Environment Variable

Set `SEED_DUMMY_DATA=false` in `.env`:

```env
# Disable dummy data seeders (Post, Category, Tag)
SEED_DUMMY_DATA=false
```

This will still run essential seeders (Menu) but skip dummy data.

#### Option 3: Command Line Flag

```bash
# Skip dummy data seeders
php artisan migrate:fresh --seed --no-dummy
```

**Note:** You need to check for `--no-dummy` flag in `DatabaseSeeder`:

```php
protected function shouldSeedDummyData(): bool
{
    if (isset($_SERVER['argv']) && in_array('--no-dummy', $_SERVER['argv'])) {
        return false;
    }
    return env('SEED_DUMMY_DATA', true);
}
```

#### Option 4: Modify DatabaseSeeder

Comment out modules you don't want to seed:

```php
// In DatabaseSeeder.php
protected function callDummyDataSeeders(): void
{
    $dummyDataModules = [
        'Post',          // Comment out to exclude
        'Category',      // Comment out to exclude
        // 'Tag',        // Excluded
    ];

    foreach ($dummyDataModules as $moduleName) {
        $this->callModuleSeeder($moduleName);
    }
}
```

### Publish and Customize Seeders

```bash
# Publish Post seeders
php artisan vendor:publish --tag=post-seeders

# Publish all module seeders
php artisan vendor:publish --tag=seeders

# Now customize in database/seeders/Post/, database/seeders/Category/, etc.
```

---

## Module-Specific Commands

### Check Module Status

```bash
# List all modules and their enabled/disabled status
php artisan module:status
```

**Output:**
```
┌──────────────┬─────────┬───────────┬──────────────┐
│ Module       │ Version │ Location  │ Dependencies │
├──────────────┼─────────┼───────────┼──────────────┤
│ Backup       │ 1.0.0   │ vendor    │ -            │
│ Category     │ 1.0.0   │ vendor    │ -            │
│ FileManager  │ 1.0.0   │ vendor    │ -            │
│ Menu         │ 1.0.0   │ vendor    │ -            │
│ Post         │ 1.0.0   │ vendor    │ Category,Tag │
│ Tag          │ 1.0.0   │ vendor    │ -            │
└──────────────┴─────────┴───────────┴──────────────┘
```

### Enable/Disable Modules

```bash
# Disable a module
php artisan module:disable Post

# Enable a module
php artisan module:enable Post
```

### Check Dependencies

```bash
# Check if all module dependencies are satisfied
php artisan module:dependencies
```

### Detect New Migrations

```bash
# Track current migration state
php artisan module:track-migrations

# After composer update, detect new migrations
php artisan module:detect-updates
```

### Compare Package vs Published

```bash
# Show differences between package and published files
php artisan module:diff Post
```

---

## Troubleshooting

### Issue: "Target class [Modules\Post\database\seeders\PostDatabaseSeeder] does not exist"

**Cause:** Incorrect namespace in seeder registration.

**Solution:** Ensure service provider uses correct namespace:

```php
// Correct namespace
'Nasirkhan\\ModuleManager\\Modules\\Post\\database\\seeders\\PostDatabaseSeeder'

// Wrong (old) namespace
'Modules\\Post\\database\\seeders\\PostDatabaseSeeder'
```

### Issue: "General error: 3780 Referencing column and referenced column are incompatible"

**Cause:** Column type mismatch between foreign key and referenced column.

**Solution:** Use `unsignedBigInteger()` for foreign keys that reference `id()` columns:

```php
// ✅ Correct
$table->unsignedBigInteger('created_by')->nullable();

// ❌ Wrong
$table->integer('created_by')->unsigned()->nullable();
```
"No menu_data.php files found"

**Cause:** Menu seeder looking for data file in wrong location (old Modules/ directory instead of package).

**Solution:** Already fixed in CurrentMenuDataSeeder to load from package:

```php
// Loads from package location
$packageMenuData = __DIR__.'/data/menu_data.php';
```

Menu data is automatically seeded from the package. No action needed.
### Issue: "Duplicate foreign key constraint"

**Cause:** Foreign key defined in both create migration and foreign keys migration.

**Solution:** Check if `foreignId()->constrained()` is used in create migration. Don't duplicate in foreign keys migration.

### Issue: Package migrations running when they shouldn't

**Cause:** Service providers are auto-discovered.

**Solution 1:** Disable the module:
```bash
php artisan module:disable Post
```

**Solution Foreign key constraint violation during seeding

**Cause:** Seeding order is wrong - Posts seeded before Categories/Tags.

**Solution:** Ensure correct seeding order in DatabaseSeeder:

```php
// ✅ Correct order
$dummyDataModules = ['Category', 'Tag', 'Post'];

// ❌ Wrong order (Posts would fail)
$dummyDataModules = ['Post', 'Category', 'Tag'];
```

### Issue: 2:** Add to `composer.json`:
```json
"extra": {
    "laravel": {
        "dont-discover": ["nasirkhan/module-manager"]
    }
}
```

Then manually register only the providers you want in `config/app.php`.

### Issue: Seeders not running

**Cause:** Module disabled in `modules_statuses.json`.

**Solution:** Enable the module:
```bash
php artisan module:enable Post
```

Or manually edit `modules_statuses.json`:
```json
{
  "Post": true
}
```

---

## Best Practices

### ✅ Do's

- **Use module:status** to check which modules are enabled
- **Track migrations** before composer updates: `php artisan module:track-migrations`
- **Use environment variables** to control seeding behavior
- **Disable unused modules** to avoid unnecessary migrations
- **Run migrate:status** regularly to see pending migrations

### ❌ Don'ts

- **Don't manually edit** package migrations (they'll be overwritten on update)
- **Don't delete** `modules_statuses.json` (modules won't load)
- **Don't mix** `integer()` and `id()` for foreign keys (type mismatch)
- **Don't duplicate** foreign key definitions in multiple migrations

---

## Quick Reference

### Common Commands

```bash
# Migration Commands
php artisan migrate              # Run all pending
php artisan migrate:fresh --seed # Fresh with seeding
php artisan migrate:status       # Check status
php artisan migrate:rollback     # Rollback last batch

# Module Commands
php artisan module:status        # List modules
php artisan module:enable Post   # Enable module
php artisan module:disable Tag   # Disable module
php artisan module:dependencies  # Check dependencies

# Seeder Commands
php artisan db:seed              # Run all seeders
php artisan db:seed --class=...  # Run specific seeder

# Package Management
php artisan vendor:publish --tag=post-migrations  # Publish migrations
php artisan vendor:publish --tag=post-seeders     # Publish seeders
php artisan module:diff Post                      # Compare changes
```

### File Locations

```
laravel-starter/
├── database/
│   ├── migrations/          # Core migrations
│   └── seeders/
│       └── DatabaseSeeder.php
├── modules_statuses.json    # Module enable/disable
└── vendor/
    └── nasirkhan/
        └── module-manager/
            └── src/
                └── Modules/
                    ├── Post/
                    │   ├── database/
                    │   │   ├── migrations/
                    │   │   └── seeders/
                    │   └── Providers/
                    │       └── PostServiceProvider.php
                    ├── Category/
                    ├── Tag/
                    └── Menu/
```

---

## Summary

- **Package migrations** are automatically loaded from enabled modules
- **Disable modules** in `modules_statuses.json` to exclude their migrations/seeders
- **Use environment variables** for fine-grained control
- **Track changes** with `module:track-migrations` and `module:detect-updates`
- **Publish and customize** seeders/migrations as needed
- **Foreign keys** must use matching column types (unsignedBigInteger)

For more details on module management, see:
- [UPGRADE.md](UPGRADE.md) - Migration upgrade guide
- [DATABASE_MIGRATION_STANDARDS.md](DATABASE_MIGRATION_STANDARDS.md) - Migration best practices
- Module-Manager package README

---

**Questions?** Check the troubleshooting section or run `php artisan module:help`
