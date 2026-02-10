# Seeder Configuration Summary

## ✅ What Was Fixed (February 10, 2026)

### 1. Menu Seeder Loading Issue
**Problem:** Menu seeder showed "No menu_data.php files found in Modules"  
**Cause:** Seeder was looking in old `Modules/` directory instead of package location  
**Fix:** Updated `CurrentMenuDataSeeder` to load from package:
```php
$packageMenuData = __DIR__.'/data/menu_data.php';
```

### 2. Seeding Order Issue  
**Problem:** Posts failed to seed due to foreign key constraint (category_id)  
**Cause:** Posts were seeded before Categories  
**Fix:** Reordered dummy data seeders:
```php
// Correct order: Category, Tag, Post
$dummyDataModules = ['Category', 'Tag', 'Post'];
```

### 3. Seeder Categorization
**Clarified:** Which seeders are essential vs optional
- **Essential (Always Run):** Auth (Users), Menu
- **Dummy Data (Optional):** Post, Category, Tag

---

## 📋 Seeder Structure

### Essential Seeders (Mandatory)
These are required for the application to function and always run:

1. **AuthTableSeeder**
   - UserTableSeeder (creates Super Admin, Admin, User)
   - PermissionRoleTableSeeder (creates permissions)
   - UserRoleTableSeeder (assigns roles)

2. **Menu Module** 
   - Creates 3 menus: Top Nav, Footer Menu, Admin Sidebar
   - Creates 50+ menu items for navigation
   - Seeds data from: `module-manager/src/Modules/Menu/database/seeders/data/menu_data.php`

### Dummy Data Seeders (Optional)
These are for development/testing and can be disabled:

3. **Category Module**
   - Seeds 10 sample categories
   
4. **Tag Module**
   - Seeds 15 sample tags
   
5. **Post Module**
   - Seeds 20 sample blog posts
   - Requires Category and Tag to be seeded first

---

## 🎮 How to Control Seeding

### Run All Seeders (Default)
```bash
php artisan migrate:fresh --seed
```
**Seeds:** Auth (Users) + Menu + Post + Category + Tag

### Skip Dummy Data
```bash
# Method 1: Environment variable
SEED_DUMMY_DATA=false php artisan migrate:fresh --seed

# Method 2: Use .env file
# Add to .env:
SEED_DUMMY_DATA=false

# Then run:
php artisan migrate:fresh --seed
```
**Seeds:** Auth (Users) + Menu only

### Run Only Specific Seeder
```bash
# Only Auth
php artisan db:seed --class=Database\\Seeders\\AuthTableSeeder

# Only Menu
php artisan db:seed --class=Nasirkhan\\ModuleManager\\Modules\\Menu\\database\\seeders\\MenuDatabaseSeeder

# Only Post
php artisan db:seed --class=Nasirkhan\\ModuleManager\\Modules\\Post\\database\\seeders\\PostDatabaseSeeder
```

### Disable Specific Modules
```bash
# Disable Post module (won't seed)
php artisan module:disable Post

# Disable multiple modules
php artisan module:disable Post
php artisan module:disable Category
php artisan module:disable Tag

# Re-enable when needed
php artisan module:enable Post
```

---

## 📊 Seeding Output

### Successful Seeding Output
```
INFO  Seeding database.

Database\Seeders\AuthTableSeeder ......................... 1,804 ms DONE  
  Default Users Created.
  Default Permissions Created.
  Default Roles created and assigned to Users.

Seeding essential modules (Menu)...
MenuDatabaseSeeder ....................................... 530 ms DONE  
  Seeding menus and menu items from PHP data...
  - 3 menus created (Top Nav, Footer, Admin Sidebar)
  - 50+ menu items created

Seeding dummy data modules (Category, Tag, Post)...
CategoryDatabaseSeeder ................................... 168 ms DONE
  Category Module Seeded
TagDatabaseSeeder ........................................ 163 ms DONE
  Tag Module Seeded
PostDatabaseSeeder ....................................... 474 ms DONE
  Post Module Seeded

Dummy data seeders completed
```

### Seeding Without Dummy Data (SEED_DUMMY_DATA=false)
```
INFO  Seeding database.

Database\Seeders\AuthTableSeeder ......................... 1,804 ms DONE  
  Default Users Created.
  Default Permissions Created.
  Default Roles created and assigned to Users.

Seeding essential modules (Menu)...
MenuDatabaseSeeder ....................................... 530 ms DONE  
  Seeding menus and menu items from PHP data...
```

---

## 🔧 Configuration Files

### .env / .env.example
```dotenv
# Seeding Configuration
# Controls whether to seed optional dummy data (Post, Category, Tag modules)
# Essential data (Users, Roles, Permissions, Menu) is always seeded
# Set to false in production or when you don't need sample content
SEED_DUMMY_DATA=true
```

### modules_statuses.json
```json
{
  "Backup": true,
  "Category": true,
  "FileManager": true,
  "Menu": true,
  "Post": true,
  "Tag": true
}
```

Set to `false` to disable a module completely (migrations + seeders + routes won't load).

### database/seeders/DatabaseSeeder.php
```php
protected function callEssentialModuleSeeders(): void
{
    $essentialModules = ['Menu'];
    // Always runs
}

protected function callDummyDataSeeders(): void
{
    // Order matters! Category and Tag must come before Post
    $dummyDataModules = ['Category', 'Tag', 'Post'];
    // Only runs if SEED_DUMMY_DATA=true
}
```

---

## ⚠️ Important Notes

### Seeding Order
The order is critical due to foreign key dependencies:
1. **Users** (required by all modules for created_by, updated_by)
2. **Menu** (essential navigation)
3. **Category** (required by Post)
4. **Tag** (required by Post)
5. **Post** (depends on Category and Tag)

### Foreign Key Dependencies
- Posts have `category_id` → Categories must exist
- Posts can be tagged → Tags must exist
- All modules have `created_by`, `updated_by` → Users must exist

### Production Considerations
```bash
# Production: Only seed essential data
SEED_DUMMY_DATA=false php artisan migrate:fresh --seed

# Or disable dummy data modules completely
php artisan module:disable Post
php artisan module:disable Category
php artisan module:disable Tag
```

---

## 📝 Quick Reference

### Check Module Status
```bash
php artisan module:status
```

### Manage Modules
```bash
php artisan module:enable Post
php artisan module:disable Post
```

### Seeding Commands
```bash
# All seeders
php artisan db:seed

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Without dummy data
SEED_DUMMY_DATA=false php artisan migrate:fresh --seed

# Specific seeder only
php artisan db:seed --class=AuthTableSeeder
```

### Environment Variables
```dotenv
SEED_DUMMY_DATA=true   # Seed Post, Category, Tag
SEED_DUMMY_DATA=false  # Only Auth + Menu
```

---

## ✅ Verification

After seeding, verify in database:
- `users` table: 3 users (Super Admin, Admin, User)
- `roles` table: 3 roles
- `permissions` table: 100+ permissions
- `menus` table: 3 menus
- `menu_items` table: 50+ items
- `categories` table: 10 categories (if dummy data enabled)
- `tags` table: 15 tags (if dummy data enabled)
- `posts` table: 20 posts (if dummy data enabled)

---

**See Also:**
- [PACKAGE_MIGRATIONS_SEEDERS.md](PACKAGE_MIGRATIONS_SEEDERS.md) - Complete migration and seeder management guide
- [DATABASE_MIGRATION_STANDARDS.md](DATABASE_MIGRATION_STANDARDS.md) - Migration standards and best practices
