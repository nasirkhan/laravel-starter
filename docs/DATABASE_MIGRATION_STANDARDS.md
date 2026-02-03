# Database Migration Standards

**Version:** v13.0.0  
**Last Updated:** February 3, 2026

## Overview

This document defines the database migration standards for Laravel Starter and module-manager package to ensure consistency, performance, and data integrity.

---

## Migration Naming Conventions

### Standard Format
```
YYYY_MM_DD_HHMMSS_action_description.php
```

**Examples:**
- `2026_02_03_184000_create_posts_table.php`
- `2026_02_03_184100_add_slug_to_posts_table.php`
- `2026_02_03_184200_add_foreign_keys_to_posts_table.php`

### Action Verbs
- `create_` - Creating new table
- `add_` - Adding columns/indexes/constraints
- `drop_` - Removing columns/indexes/constraints  
- `alter_` - Modifying existing columns
- `rename_` - Renaming table/columns

---

## Foreign Key Standards

### When to Use
- All `*_id` columns should have foreign key constraints
- Audit fields (`created_by`, `updated_by`, `deleted_by`) should reference users

### Constraint Actions

**1. cascadeOnDelete()** - For required relationships
```php
$table->foreign('menu_id')
      ->references('id')
      ->on('menus')
      ->cascadeOnDelete();
```
**Use when:** Child records should be deleted when parent is deleted (e.g., menu items when menu is deleted)

**2. nullOnDelete()** - For optional relationships
```php
$table->foreign('category_id')
      ->references('id')
      ->on('categories')
      ->nullOnDelete();
```
**Use when:** Child should remain but relationship can be broken (e.g., posts remain when category deleted)

**3. noActionOnDelete()** - For audit trail
```php
$table->foreign('created_by')
      ->references('id')
      ->on('users')
      ->noActionOnDelete();
```
**Use when:** Preserving historical data (e.g., keeping user ID even after user deleted)

### Example
```php
Schema::table('posts', function (Blueprint $table) {
    // Required relationship - cascade
    $table->foreign('category_id')
          ->references('id')
          ->on('categories')
          ->nullOnDelete();

    // Audit fields - preserve history
    $table->foreign('created_by')
          ->references('id')
          ->on('users')
          ->noActionOnDelete();
});
```

---

## Index Standards

### When to Add Indexes

**Always index:**
- Primary keys (automatic)
- Foreign key columns
- Unique columns (slug, email, username)
- Status/enum columns
- Frequently queried columns

**Consider indexing:**
- Date/timestamp columns used in sorting
- Boolean flags used in WHERE clauses
- Columns used in JOIN conditions

### Index Types

**1. Single Column Index**
```php
$table->index('status');
$table->index('created_by');
```

**2. Unique Index**
```php
$table->unique('slug');
$table->unique('email');
```

**3. Composite Index**
```php
// For queries that filter by both columns
$table->index(['status', 'published_at'], 'posts_status_published_index');
```

**4. Full-Text Index (MySQL only)**
```php
if (Schema::connection($this->getConnection())->getConnection()->getDriverName() === 'mysql') {
    DB::statement('ALTER TABLE posts ADD FULLTEXT search_index (name, intro, content)');
}
```

### Example
```php
Schema::table('posts', function (Blueprint $table) {
    // Unique indexes
    $table->unique('slug');
    
    // Foreign key indexes
    $table->index('category_id');
    $table->index('created_by');
    
    // Query performance indexes
    $table->index('status');
    $table->index('published_at');
    
    // Composite indexes for common queries
    $table->index(['status', 'published_at'], 'posts_status_published_index');
});
```

---

## Column Type Standards

### Foreign Keys
**Modern Laravel (8+):**
```php
$table->foreignId('user_id')->constrained();
```

**Legacy/Explicit:**
```php
$table->unsignedBigInteger('user_id');
$table->foreign('user_id')->references('id')->on('users');
```

### Status Fields

**With Enums (Recommended):**
```php
use App\Enums\PostStatus;

$table->string('status')->default(PostStatus::Draft->value);
```

**Boolean Flags:**
```php
$table->boolean('is_active')->default(true);
$table->boolean('is_featured')->default(false);
```

### Timestamps

**Standard Laravel:**
```php
$table->timestamps(); // created_at, updated_at
$table->softDeletes(); // deleted_at
```

**Custom Timestamps:**
```php
$table->timestamp('published_at')->nullable();
$table->timestamp('moderated_at')->nullable();
```

### Audit Fields

**Standard Pattern:**
```php
$table->unsignedBigInteger('created_by')->nullable();
$table->unsignedBigInteger('updated_by')->nullable();
$table->unsignedBigInteger('deleted_by')->nullable();

// Add foreign keys separately
$table->foreign('created_by')->references('id')->on('users')->noActionOnDelete();
```

---

## Migration File Structure

### Template
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * [Brief description of what this migration does and why]
     */
    public function up(): void
    {
        Schema::table('table_name', function (Blueprint $table) {
            // Group related changes
            // Add comments for complex logic
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('table_name', function (Blueprint $table) {
            // Reverse changes in opposite order
        });
    }
};
```

### Best Practices

**1. Document Complex Logic**
```php
/**
 * Run the migrations.
 *
 * Add full-text search index to posts table for content search.
 * Only applies to MySQL databases.
 */
public function up(): void
{
    // Implementation
}
```

**2. Group Related Changes**
```php
Schema::table('posts', function (Blueprint $table) {
    // Foreign keys
    $table->foreign('category_id')->references('id')->on('categories');
    $table->foreign('created_by')->references('id')->on('users');
    
    // Indexes
    $table->index('status');
    $table->index('published_at');
});
```

**3. Always Provide Rollback**
```php
public function down(): void
{
    Schema::table('posts', function (Blueprint $table) {
        // Drop in reverse order
        $table->dropIndex(['status']);
        $table->dropForeign(['category_id']);
    });
}
```

---

## Module Migration Guidelines

### Location
Module migrations live in: `src/Modules/{Module}/database/migrations/`

### Publishing
When users publish module migrations, they get current timestamps:
```bash
php artisan vendor:publish --tag=post-migrations
# Creates: database/migrations/2026_02_03_120000_create_posts_table.php
```

### Testing
Always test both `up()` and `down()` methods:
```bash
# Test migration
php artisan migrate

# Test rollback
php artisan migrate:rollback

# Test fresh migration
php artisan migrate:fresh
```

---

## Common Patterns

### Self-Referencing Foreign Keys
```php
// For hierarchical data (parent_id)
$table->foreignId('parent_id')
      ->nullable()
      ->constrained('menu_items')
      ->cascadeOnDelete();
```

### Polymorphic Relationships
```php
// Pivot table
Schema::create('taggables', function (Blueprint $table) {
    $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
    $table->morphs('taggable'); // Creates taggable_id, taggable_type
    
    $table->unique(['tag_id', 'taggable_id', 'taggable_type']);
});
```

### JSON Columns
```php
$table->json('settings')->nullable();
$table->json('meta_data')->nullable();
```

---

## Performance Considerations

### Index Selection
- **Too few indexes:** Slow queries
- **Too many indexes:** Slow writes, more storage
- **Rule of thumb:** Index columns used in WHERE, ORDER BY, JOIN

### Composite Index Order
```php
// Good - status is filtered first, then sorted by date
$table->index(['status', 'published_at']);

// Bad - sorting before filtering
$table->index(['published_at', 'status']);
```

### Full-Text Indexes
Only use for search features:
```php
// MySQL full-text search
DB::statement('ALTER TABLE posts ADD FULLTEXT search_index (name, content)');

// Use with:
Post::whereRaw('MATCH(name, content) AGAINST(? IN BOOLEAN MODE)', [$term])->get();
```

---

## Migration Testing Checklist

Before committing migrations:

- [ ] Migration runs successfully (`php artisan migrate`)
- [ ] Rollback works (`php artisan migrate:rollback`)
- [ ] Fresh migration works (`php artisan migrate:fresh`)
- [ ] Foreign keys reference correct tables
- [ ] Indexes are on correct columns
- [ ] Down() method reverses all changes
- [ ] Documentation comments are clear
- [ ] No syntax errors in MySQL/PostgreSQL

---

## Examples from Laravel Starter

### Users Table (laravel-starter)
```php
// Foreign keys
$table->foreign('created_by')->references('id')->on('users')->noActionOnDelete();

// Indexes
$table->index('email');
$table->index('status');
$table->index(['status', 'last_login'], 'users_status_login_index');
```

### Posts Table (module-manager)
```php
// Foreign keys
$table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
$table->foreign('created_by')->references('id')->on('users')->noActionOnDelete();

// Indexes
$table->unique('slug');
$table->index('status');
$table->index(['status', 'published_at'], 'posts_status_published_index');
```

### Menu Items Table (module-manager)
```php
// Foreign keys
$table->foreign('menu_id')->references('id')->on('menus')->cascadeOnDelete();
$table->foreign('parent_id')->references('id')->on('menu_items')->cascadeOnDelete();

// Indexes
$table->index(['menu_id', 'parent_id', 'order'], 'menu_items_hierarchy_index');
```

---

## Resources

- [Laravel Migration Documentation](https://laravel.com/docs/12.x/migrations)
- [Database Indexes Best Practices](https://use-the-index-luke.com/)
- Laravel Starter IMPROVEMENT_ROADMAP.md
- Laravel Starter PHASE_3_TASKS.md
