# Database Seeding

This Laravel application provides flexible database seeding options to accommodate different development scenarios.

## Types of Seeders

### Essential Seeders (Always Run)
- **Users, Roles & Permissions** (`AuthTableSeeder`)
- **Menu & Navigation** (`MenuDatabaseSeeder`)

These seeders create the core data required for the application to function properly.

### Dummy Data Seeders (Optional)
- **Posts** (`PostDatabaseSeeder`)
- **Categories** (`CategoryDatabaseSeeder`)
- **Tags** (`TagDatabaseSeeder`)

These seeders create sample content for development and testing purposes.

## Seeding Options

### 1. Full Seeding (Default)
Seeds both essential data and dummy data:
```bash
php artisan migrate:fresh --seed
```

### 2. Essential Data Only

#### Option A: Environment Variable
Set in your `.env` file:
```env
SEED_DUMMY_DATA=false
```
Then run:
```bash
php artisan migrate:fresh --seed
```

#### Option B: Custom Command
```bash
# Seed only essential data
php artisan db:seed-essential

# Fresh migration + essential data only
php artisan db:seed-essential --fresh
```

#### Option C: Runtime Environment Variable (PowerShell)
```powershell
$env:SEED_DUMMY_DATA="false"; php artisan migrate:fresh --seed
```

### 3. Dummy Data Only
If you already have essential data and only want to add dummy content:
```bash
php artisan db:seed --class="Modules\Post\database\seeders\PostDatabaseSeeder"
php artisan db:seed --class="Modules\Category\database\seeders\CategoryDatabaseSeeder"
php artisan db:seed --class="Modules\Tag\database\seeders\TagDatabaseSeeder"
```

## Environment Configuration

### .env Variables
```env
# Control dummy data seeding (default: true)
SEED_DUMMY_DATA=true
```

### Production Considerations
- Essential seeders are safe for production (users, roles, menus)
- Dummy data seeders should typically be disabled in production
- Use `--force` flag for production environments:
```bash
php artisan db:seed-essential --fresh --force
```

## Module Status Control

Individual modules can be enabled/disabled via `modules_statuses.json`:
```json
{
    "Post": true,     // Dummy data module
    "Category": true, // Dummy data module  
    "Tag": true,      // Dummy data module
    "Menu": true      // Essential module
}
```

## Testing Environment

During automated testing:
- Seeder output is suppressed to keep test logs clean
- Both essential and dummy data are seeded by default
- Override with `SEED_DUMMY_DATA=false` for faster test execution

## Examples

### Development Setup
```bash
# Full development environment with sample content
php artisan migrate:fresh --seed
```

### Production Deployment
```bash
# Production with only essential data
SEED_DUMMY_DATA=false php artisan migrate:fresh --seed --force
```

### Quick Development Reset
```bash
# Reset with only essential data for clean slate
php artisan db:seed-essential --fresh
```

### Staging Environment
```bash
# Add sample content to existing essential data
SEED_DUMMY_DATA=true php artisan db:seed
```