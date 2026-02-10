# Laravel Starter - Improvement Roadmap

**Last Updated:** February 3, 2026  
**Current Version:** v12.20.0  
**Target Release:** v13.0.0 (includes core modules separation to module-manager package)

This document outlines recommended improvements to enhance Laravel Starter as both a base starter project and a maintainable, updateable template. All changes will be implemented in sequence for the v13 release.

**Recent Updates:**
- Added detailed Livewire 4 standardization section with specific component conversion list
- Added route consistency section for converting CRUD operations to Livewire
- Added database improvements section with migration standardization
- Enhanced security section with additional security enhancements
- Added frontend component organization section
- Updated priority matrix with new critical tasks
- Updated progress tracking with new categories

---

## 🎯 Overview

This roadmap focuses on two key objectives:
1. **Base Starter Quality** - Making it easy for developers to start new projects
2. **Updateability** - Ensuring projects built on this starter can receive updates

---

## 📦 Updateability Strategy (CRITICAL)

> **🎯 Key Insight:** Follow Laravel's native package override pattern. Don't reinvent the wheel - use the same proven approach that Spatie, Laravel Nova, and Filament use. Simpler, more reliable, and developers already know it!

Based on research of successful Laravel starter projects (Breeze, Jetstream, Filament) and **Laravel's native override patterns**, here's a comprehensive strategy for making this starter updateable.

### Core Philosophy: The Laravel Way

**Follow Laravel's native override pattern** - Just like Laravel itself, files in user space override package/core files automatically. This is the cleanest, most Laravel-native approach.

#### Laravel's Override Pattern Examples:
- **Views**: `resources/views/vendor/package-name/view.blade.php` overrides package views
- **Config**: Published configs in `config/` override package defaults via `mergeConfigFrom()`
- **Translations**: `lang/vendor/package/` overrides package translations
- **Migrations**: Published migrations are user-owned and never overwritten

### Core Principles

#### 1. **Core vs User Space Separation**

**Core Modules (Package Space)** - Lives in `vendor/nasirkhan/module-manager/src/Modules/`
- Default, updateable modules (Post, Category, Tag, Menu) **included in module-manager package**
- Can be updated via `composer update nasirkhan/module-manager`
- Users should NOT edit these directly

**User Space (Override Location)** - Lives in `Modules/`
- Users publish/export modules they want to customize
- `php artisan module:publish Post` → copies to `Modules/Post/`
- Once published, user owns it and it won't be overwritten
- Can pick which parts to publish (controllers, views, config, etc.)

**Laravel's View Resolution (Built-in)**
```php
// In Module Service Provider (in module-manager package)
$this->loadViewsFrom(__DIR__.'/../Resources/views', 'post');

// Laravel automatically checks in this order:
// 1. resources/views/vendor/post/  (user override - if published)
// 2. vendor/nasirkhan/module-manager/src/Modules/Post/Resources/views/   (package default)

// Usage in code:
view('post::index');  // Laravel handles the override automatically!
```

#### 2. **Distribution Model: Hybrid (Following Laravel's Pattern)**

**Core Distribution** - Composer Package
- `composer require nasirkhan/laravel-starter` (core framework)
- `composer require nasirkhan/module-manager` (includes management tools + default modules)
- Users keep everything updated via `composer update`

**User Customization** - Selective Publishing
- Core modules stay in vendor by default (updateable)
- Publish only what you need to customize:
  ```bash
  # Publish entire module to Modules/ for full customizationv
  php artisan module:publish Post
  
  # Or publish specific parts
  php artisan vendor:publish --tag=post-views
  php artisan vendor:publish --tag=post-config
  php artisan vendor:publish --tag=post-migrations
  ```
- Once published, Laravel's native resolution takes over

> **🎯 Architecture Decision:** We're enhancing the existing `nasirkhan/module-manager` package to include default modules, rather than creating a separate `laravel-starter-modules` package. This keeps things simpler since module-manager is already Laravel Starter specific.

### Implementation Roadmap

#### Phase 1: module-manager to Include Default Modules**
- [x] **Enhance module-manager package structure** ✅ *Completed: Feb 3, 2026*
  - Updated all 4 module service providers (Post, Category, Tag, Menu)
  - Implemented Laravel's native publishing patterns
  - Created comprehensive test suite (ModulePublishingTest.php)
  ```
  nasirkhan/module-manager/
  ├── src/
  │   ├── Commands/              (Existing + new commands)
  │   │   ├── ModuleMakeCommand.php
  │   │   ├── ModulePublishCommand.php   (NEW)
  │   │   ├── ModuleStatusCommand.php    (Exists via module:status)
  │   │   ├── ModuleDiffCommand.php      (NEW)
  │   │   └── ...
  │   ├── Modules/               (Ready for extraction)
  │   │   ├── Post/
  │   │   │   ├── PostServiceProvider.php ✅
  │   │   │   ├── Http/Controllers/
  │   │   │   ├── Models/
  │   │   │   ├── Resources/views/
  │   │   │   ├── Config/
  │   │   │   └── Database/
  │   │   ├── Category/ ✅
  │   │   ├── Tag/ ✅
  │   │   └── Menu/ ✅
  │   └── ModuleServiceProvider.php (Enhanced)
  └── composer.json
  ```

- [x] **Module Service Providers** (Laravel's native pattern) ✅ *Completed: Feb 3, 2026*

  ```php
  // vendor/nasirkhan/module-manager/src/Modules/Post/PostServiceProvider.php
  
  class PostServiceProvider extends ServiceProvider
  {
      public function boot(): void
      {
          // Load from package by default
          $this->loadViewsFrom(__DIR__.'/Resources/views', 'post');
          $this->loadTranslationsFrom(__DIR__.'/lang', 'post');
          
          // If running in console, allow publishing
          if ($this->app->runningInConsole()) {
              $this->publishes([
                  __DIR__.'/Resources/views' => resource_path('views/vendor/post'),
              ], 'post-views');
              
              $this->publishes([
                  __DIR__.'/Config/config.php' => config_path('post.php'),
              ], 'post-config');
              
              $this->publishesMigrations([
                  __DIR__.'/Database/Migrations' => database_path('migrations'),
              ], 'post-migrations');
              
              // Entire module publishing
              $this->publishes([
                  __DIR__ => base_path('Modules/Post'),
              ], 'post-module');
          }
          
          // Merge config (user config overrides package defaults)
          $this->mergeConfigFrom(__DIR__.'/Config/config.php', 'post');
      }
  }
  ```

- [x] **Publishing system implemented** ✅ *Completed: Feb 3, 2026*
  - All modules now support Laravel's native `vendor:publish`
  - Publishing tags implemented for all 4 modules
  - Tested and validated with ModulePublishingTest (12 tests, 23 assertions)
  ```bash
  # Selective publishing now working:
  php artisan vendor:publish --tag=post-views      # ✅ Only views
  php artisan vendor:publish --tag=post-config     # ✅ Only config
  php artisan vendor:publish --tag=post-migrations # ✅ Only migrations
  php artisan vendor:publish --tag=post-livewire-components # ✅ Livewire components
  
  # Same for category, tag, menu modules
  # Full module publishing via module:publish command (to be enhanced)
  ```

- [ ] **Auto-discovery for modules** (Next: Move to module-manager package)
  ```json
  // module-manager/composer.json
  {
    "extra": {
      "laravel": {
        "providers": [
          "Nasirkhan\\ModuleManager\\ModuleServiceProvider",
          "Nasirkhan\\ModuleManager\\Modules\\Post\\PostServiceProvider",
          "Nasirkhan\\ModuleManager\\Modules\\Category\\CategoryServiceProvider",
          "Nasirkhan\\ModuleManager\\Modules\\Tag\\TagServiceProvider",
          "Nasirkhan\\ModuleManager\\Modules\\Menu\\Menu
          "LaravelStarterModules\\Post\\PostServiceProvider",
          "LaravelStarterModules\\Category\\CategoryServiceProvider"
        ]
      }
    }
  }
  ```

#### Phase 2: Versioning Strategy
- [ ] **Adopt Semantic Versioning (SemVer)**
  - MAJOR.MINOR.PATCH format
  - MAJOR: Breaking changes
  - MINOR: New features, backward compatible
  - PATCH: Bug fixes, backward compatible
  
- [ ] **Version compatibility matrix**
  ```
  Laravel Starter 12.x → Laravel 12.x, PHP 8.2-8.3, Livewire 4.x
  Laravel Starter 2.x  → Laravel 11.x, PHP 8.1-8.2, Livewire 3.x
  Laravel Starter 1.x  → Laravel 10.x, PHP 8.1, Livewire 2.x
  ```

- [ ] **Branch strategy**
  - `main` - Latest stable release (v12.x)
  - `develop` - Next version development (v13.x)
  - `12.x`, `2.x`, `1.x` - Maintenance branches for older versions

#### Phase 3: Update Mechanism (Laravel Native)

**Updates Follow Laravel's Pattern**
- [ ] **Core/Package updates** - Simple composer update
  ```bash
  composer update nasirkhan/laravel-starter
  composer update nasirkhan/laravel-starter-modules
  ```
  - Package modules in vendor/ get updated
  - Published files in user space are NEVER touched
  - Laravel's resolution picks user files first automatically

- [ ] **Module status command**
  ```bash
  php artisan module:status
  
  # Output:
  # Module    Location           Version    Updates
  # -------   ---------          -------    -------
  # Post      vendor (package)   v3.1.0     ✓ Up to date
  # Category  Modules/ (custom)  v12.20.0   ⚠ Customized, check changelog
  # Tag       vendor (package)   v12.20.0   → v12.21.0 available
  # Menu      Modules/ (custom)  v2.9.0     ⚠ Customized, 2 versions behind
  ```

- [ ] **Module diff command** (for customized modules)
  ```bash
  php artisan module:diff Category
  
  # Shows diff between:
  # - vendor/.../Category/ (latest package version)
  # - Modules/Category/ (your customized version)
  
  # Helps user decide what to merge from updates
  ```

- [ ] **Migration update strategy**
  - Package migrations use `publishesMigrations()` method
  - Published migrations get timestamped when published
  - User can choose when to publish new migrations
  ```bash
  # Check for new migrations from updated packages
  php artisan module:check-migrations
  
  # Publish new migrations
  php artisan vendor:publish --tag=post-migrations --force
  ```

#### Phase 4: Configuration Management (Laravel's MergeConfigFrom)
- [ ] **Use Laravel's native config override**
  ```php
  // In package: packages/.../Post/Config/config.php
  return [
      'per_page' => 10,
      'enable_comments' => true,
      'cache_ttl' => 3600,
  ];
  
  // In PostServiceProvider:
  $this->mergeConfigFrom(__DIR__.'/Config/config.php', 'post');
  
  // User publishes to override:
  php artisan vendor:publish --tag=post-config
  
  // Creates: config/post.php (user can customize)
  return [
      'per_page' => 25,  // User override
      // Other values inherited from package
  ];
  
  // Access anywhere:
  config('post.per_page')  // Returns 25 (user override)
  config('post.cache_ttl')  // Returns 3600 (package default)
  ```
  
- [ ] **Environment-based overrides**
  ```php
  // Package provides defaults
  // .env overrides everything
  
  // config/post.php
  return [
      'per_page' => env('POST_PER_PAGE', config('post.per_page', 10)),
  ];
  ```

#### Phase 5: Database Migration Strategy (Laravel's publishesMigrations)
- [ ] **Use Laravel's native migration publishing**
  ```php
  // In Module Service Provider
  public function boot(): void
  {
      $this->publishesMigrations([
          __DIR__.'/Database/Migrations' => database_path('migrations'),
      ], 'post-migrations');
      
      // Or load from package directly (not recommended for user projects)
      $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
  }
  ```
  
- [ ] **Migration workflow**
  ```bash
  # New installation - publish all migrations
  php artisan vendor:publish --tag=post-migrations
  php artisan migrate
  
  # After module update with new migrations
  php artisan vendor:publish --tag=post-migrations --force
  # New migrations get current timestamp, run with:
  php artisan migrate
  
  # Migrations are now user-owned, won't be overwritten
  ```
  
- [ ] **Track module migrations separately** (optional enhancement)
  ```bash
  # See which migrations belong to which module
  php artisan module:migrations
  
  # Module      Migrations                            Status
  # Post        2024_01_01_create_posts_table        ✓ Ran
  # Post        2024_01_15_add_featured_to_posts     ✓ Ran  
  # Post        2026_01_30_add_scheduled_to_posts    ⏳ Pending
  # Category    2024_01_01_create_categories_table   ✓ Ran
  ```

#### Phase 6: Module Customization Workflow (The Laravel Way)

**Key Insight: Follow Laravel's Package Override Pattern**

Laravel already has a proven pattern for this - packages provide defaults, users override what they need. No complex tracking, checksums, or smart merging needed!

##### Livewire v4 Component Customization (IMPORTANT)

Since modules will use Livewire v4 extensively, here's how the override pattern works for Livewire components:

**Understanding Livewire Components:**
- A Livewire component = PHP Class (logic) + Blade View (UI)
- Both parts can be customized, but differently

**Pattern 1: View-Only Override** (Easiest - No Code Changes)
```php
// In Module Service Provider (package)
public function boot(): void
{
    // Register Livewire component views with namespace
    $this->loadViewsFrom(__DIR__.'/Resources/views/livewire', 'post');
}

// Package Livewire component
namespace Nasirkhan\ModuleManager\Modules\Post\Livewire;

#[Layout('components.layouts.app')]
class PostsIndex extends Component
{
    public function render()
    {
        return view('post::posts-index'); // Uses namespace
    }
}
```

**User Override:**
```bash
# Publish only Livewire views
php artisan vendor:publish --tag=post-views

# Creates: resources/views/vendor/post/posts-index.blade.php
# Laravel automatically uses YOUR view, package logic stays intact!
```

**Pattern 2: Full Component Extension** (When you need custom logic)
```php
// User extends package Livewire component

// app/Livewire/CustomPostsIndex.php
namespace App\Livewire;

use Nasirkhan\ModuleManager\Modules\Post\Livewire\PostsIndex as BasePostsIndex;

class CustomPostsIndex extends BasePostsIndex
{
    // Add custom properties
    public bool $showFeatured = true;
    
    // Override methods
    public function render()
    {
        $posts = Post::query()
            ->when($this->showFeatured, fn($q) => $q->where('featured', true))
            ->paginate(20);
            
        // Use your own view or parent's view
        return view('livewire.custom-posts-index', compact('posts'));
    }
    
    // All other parent methods inherited
}

// Use in routes
Route::get('/posts', CustomPostsIndex::class);
```

**Pattern 3: Component Binding** (Automatic override)
```php
// In AppServiceProvider (user project)
public function register(): void
{
    // Any time package tries to use PostsIndex, use CustomPostsIndex instead
    $this->app->bind(
        \Nasirkhan\ModuleManager\Modules\Post\Livewire\PostsIndex::class,
        \App\Livewire\CustomPostsIndex::class
    );
}

// Now package routes automatically use your custom component!
```

**Pattern 4: Livewire Component Aliases** (Advanced)
```php
// In Module Service Provider (package)
public function boot(): void
{
    Livewire::component('post.index', PostsIndex::class);
}

// User can override the alias
// In AppServiceProvider (user project)
public function boot(): void
{
    // Override the alias to use custom component
    Livewire::component('post.index', CustomPostsIndex::class);
}

// Usage in Blade remains same
<livewire:post.index />
```

**Recommended Module Structure for Livewire:**
```
Modules/Post/
├── Livewire/
│   ├── PostsIndex.php
│   ├── PostsCreate.php
│   ├── PostsEdit.php
│   └── PostsShow.php
├── Resources/views/livewire/
│   ├── posts-index.blade.php
│   ├── posts-create.blade.php
│   ├── posts-edit.blade.php
│   └── posts-show.blade.php
└── PostServiceProvider.php
```

**Publishing Strategy for Livewire:**
```php
// In PostServiceProvider
public function boot(): void
{
    // 1. Register views (overrideable)
    $this->loadViewsFrom(__DIR__.'/Resources/views/livewire', 'post');
    
    if ($this->app->runningInConsole()) {
        // 2. Publish Livewire views
        $this->publishes([
            __DIR__.'/Resources/views/livewire' => resource_path('views/vendor/post'),
        ], 'post-livewire-views');
        
        // 3. Publish entire Livewire components (both class + view)
        $this->publishes([
            __DIR__.'/Livewire' => app_path('Livewire/Post'),
            __DIR__.'/Resources/views/livewire' => resource_path('views/livewire/post'),
        ], 'post-livewire-components');
    }
}
```

**User Customization Workflow:**
```bash
# Option 1: Just customize the UI (view only)
php artisan vendor:publish --tag=post-livewire-views
# Edit: resources/views/vendor/post/posts-index.blade.php
# Package logic stays updateable ✓

# Option 2: Customize both logic and UI
php artisan vendor:publish --tag=post-livewire-components
# Edit: app/Livewire/Post/PostsIndex.php
# Edit: resources/views/livewire/post/posts-index.blade.php
# You own them completely ✓

# Option 3: Extend component (best of both worlds)
# Create: app/Livewire/CustomPostsIndex.php extends package component
# Inherit bug fixes, add custom features ✓
```

**Key Takeaway for Livewire in Modules:**
- ✅ View overrides work EXACTLY like regular Blade views
- ✅ Component class extension works like controller extension
- ✅ Both patterns are "Laravel native" and developers know them
- ✅ Updates are safe - user customizations preserved
- ✅ Livewire v4 attributes (#[Layout], #[Title]) make this even cleaner!

**Real-World Livewire v4 Example:**
```php
// Package: vendor/nasirkhan/module-manager/src/Modules/Post/Livewire/PostsIndex.php
namespace Nasirkhan\ModuleManager\Modules\Post\Livewire;

use Livewire\Component;
use Livewire\Attributes\{Layout, Title, Url};
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('Posts')]
class PostsIndex extends Component
{
    use WithPagination;
    
    #[Url]
    public string $search = '';
    
    public function render()
    {
        $posts = Post::query()
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate(15);
            
        return view('post::posts-index', compact('posts'));
    }
}

// User extends it:
// app/Livewire/EnhancedPostsIndex.php
namespace App\Livewire;

use Nasirkhan\ModuleManager\Modules\Post\Livewire\PostsIndex as BasePostsIndex;
use Livewire\Attributes\{Layout, Title};

#[Layout('layouts.custom-admin')]  // Different layout
#[Title('Manage All Posts')]       // Different title
class EnhancedPostsIndex extends BasePostsIndex
{
    // Add category filter
    #[Url]
    public ?int $categoryId = null;
    
    // Override render to add category filtering
    public function render()
    {
        $posts = Post::query()
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->categoryId, fn($q) => $q->where('category_id', $this->categoryId))
            ->latest()
            ->paginate(15);
            
        $categories = Category::all();
        
        // Use custom view
        return view('livewire.enhanced-posts-index', compact('posts', 'categories'));
    }
    
    // Inherited methods: search, pagination, etc. still work!
}

// Route uses your custom component
Route::get('/admin/posts', EnhancedPostsIndex::class)->name('admin.posts');
```

---

**The Workflow**

1. **Default State** - Module in vendor (updateable)
   ```
   vendor/
   └── nasirkhan/module-manager/src/Modules/Post/
       ├── PostServiceProvider.php  (registers views with 'post' namespace)
       ├── Http/Controllers/
       ├── Models/
       ├── Resources/views/
       └── Config/config.php
   ```
   - All files in module-manager package, updated via `composer update`
   - Laravel automatically uses these
   - Use in code: `view('post::index')`, `config('post.per_page')`

2. **Customize Views** - Publish only views
   ```bash
   php artisan vendor:publish --tag=post-views
   ```
   Creates: `resources/views/vendor/post/index.blade.php`
   - Laravel AUTOMATICALLY checks `resources/views/vendor/post/` first
   - Falls back to package if not found
   - Update package: `composer update` - your views untouched!

3. **Customize Config** - Publish only config  
   ```bash
   php artisan vendor:publish --tag=post-config
   ```
   Creates: `config/post.php`
   - Your values override package defaults (via `mergeConfigFrom`)
   - Update package: `composer update` - your config untouched!

4. **Full Customization** - Publish entire module
   ```bash
   php artisan module:publish Post
   ```
   Copies: `vendor/.../Post/` → `Modules/Post/`
   - Now you own the entire module
   - Make any changes you want
   - Update package: Your module is ignored
   - Check updates: `php artisan module:diff Post`

**Example: Real World Scenario**

```bash
# Project A: Only needs custom post views
php artisan vendor:publish --tag=post-views
# Edit resources/views/vendor/post/index.blade.php
# composer update - views preserved ✓

# Project B: Needs custom post controller logic
php artisan module:publish Post
# Edit Modules/Post/Http/Controllers/PostController.php
# Update routes to use Modules\Post namespace
# composer update - entire module preserved ✓

# Project C: Just override config
php artisan vendor:publish --tag=post-config
# Edit config/post.php to change pagination
# composer update - config preserved ✓
```

**Handling Deep Customizations**

When you need MORE than just view/config changes:

**Pattern 1: Controller Extension** (Class-based override)
```php
// Don't modify package controller directly
// Extend it in your app

// app/Http/Controllers/CustomPostController.php
namespace App\Http\Controllers;

use Nasirkhan\ModuleManager\Modules\Post\Http\Controllers\PostController as BaseController;

class CustomPostController extends BaseController
{
    // Override only what you need
    public function index()
    {
        $featuredPosts = Post::where('featured', true)->limit(3)->get();
        
        // Call parent or rewrite completely
        return view('post::index', [
            'posts' => Post::latest()->paginate(20),
            'featured' => $featuredPosts,
        ]);
    }
    
    // All other methods inherited from parent
}

// routes/web.php - Use your extended controller
Route::get('/posts', [CustomPostController::class, 'index']);
```

**Pattern 2: View Publishing** (Laravel automatic)
```bash
# Publish views
php artisan vendor:publish --tag=post-views

# Edit resources/views/vendor/post/index.blade.php
# Laravel automatically uses YOUR version
# Package updates won't touch it
```

**Pattern 3: Route Override** (Service Provider)
```php
// In your AppServiceProvider or RouteServiceProvider
public function boot(): void
{
    // Override package routes with your own
    Route::middleware('web')->group(function () {
        Route::get('/posts/{post}', [CustomPostController::class, 'show'])
            ->name('posts.show'); // This takes precedence
    });
}
```

**Pattern 4: Model Extension** (If you need to change model behavior)
```php
// app/Models/Post.php
namespace App\Models;

use Nasirkhan\ModuleManager\Modules\Post\Models\Post as BasePost;

class Post extends BasePost
{
    // Add custom methods
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
    
    // Override methods if needed
    public function getRouteKeyName()
    {
        return 'slug';
    }
}

// In AppServiceProvider, bind your model
$this->app->bind(
    \Nasirkhan\ModuleManager\Modules\Post\Models\Post::class,
    \App\Models\Post::class
);
```

**Update Workflow: Simple & Clean**

```bash
# 1. Check what needs updating
composer show nasirkhan/module-manager

# 2. Update packages (includes both tools and default modules)
composer update nasirkhan/module-manager

# ✓ Management tools updated
# ✓ Default modules updated  
# ✓ Your published views/configs untouched
# ✓ Your Modules/ directory untouched
# ✓ Laravel automatically uses your overrides

# 3. Check if there are new migrations
php artisan module:check-migrations

# Output:
# New migrations available:
# - Post: 2026_01_30_add_scheduled_to_posts.php
# 
# Publish with:
# php artisan vendor:publish --tag=post-migrations

# 4. If you have a fully published module, check what changed
php artisan module:diff Post

# Shows:
# Differences betweenmodule-manager/src/Modules
# - vendor/nasirkhan/laravel-starter-modules/src/Post/ (v3.1.0)
# - Modules/Post/ (your v12.20.0 customized version)
# 
# Review changes and manually merge if desired

# 5. Review CHANGELOG.md and UPGRADE.md for breaking changes
```

**The Beauty of This Approach:**
- ✅ No complex merge algorithms
- ✅ No checksum tracking
- ✅ No smart merge conflicts
- ✅ No .module-meta directories
- ✅ Laravel handles everything natively
- ✅ Same pattern as Spatie, Laravel Nova, Filament
- ✅ Developers already know this pattern
- ✅ Clean separation: package vs user space

**Module-Manager Package Enhancements Required**

The `nasirkhan/module-manager` package needs these additions:

```php
// New commands to add to module-manager
php artisan module:check-updates {module?}
php artisan module:update {module} {--dry-run} {--force} {--backup}
php artisan module:diff {module} {file?}
php artisan module:publish-views {module}
php artisan module:publish-config {module}
php artisan module:reset {module}  // Reset to original state

// New Module methods
Module::hasUpdates($name)
Module::getVersion($name)
Module::getLatestVersion($name)
Module::isModified($name)
Module::getModifiedFiles($name)
Module::createChecksum($name)
Module::compareVersions($name, $version1, $version2)
```

### Update Distribution Channels

#### 1. Via Composer (Recommended)
```bash
# Check for updates
composer show nasirkhan/laravel-starter

# Update to latest compatible version
composer update nasirkhan/laravel-starter

# Update to specific version
composer require nasirkhan/laravel-starter:^3.0
```

#### 2. Via Artisan Command
```bash
# Check for updates
php artisan starter:check-updates

# Update to latest version
php artisan starter:update

# Update with backup
php artisan starter:update --backup

# View what will be updated
php artisan starter:update --dry-run
```

#### 3. Via Manual Git Merge
```bash
# Add upstream remote (first time only)
git remote add starter https://github.com/nasirkhan/laravel-starter.git

# Fetch latest changes
git fetch starter

# Merge updates (careful with conflicts)
git merge starter/main

# Or rebase for cleaner history
git rebase starter/main
```

### File Classification System

Create a clear file ownership structure:

#### Core Files (Updateable)
```
✅ Safe to overwrite during updates
packages/laravel-starter/
vendor/
bootstrap/app.php (partially)
config/starter.php
```

#### Generated Files (User-Owned)
```
⚠️ Generated once, then user-owned
app/Http/Controllers/
resources/views/
routes/web.php
.env
```

#### Hybrid Files (Requires Merging)
```
🔄 May require manual merging
composer.json
package.json
config/app.php
database/migrations/
```

Add markers to files:
```php
// @laravel-starter-core - Don't modify this file directly
// Your changes will be overwritten on updates

// @laravel-starter-customizable - Safe to modify
// Updates will respect your changes
```

### Documentation Requirements

#### Must-Have Docs
- [ ] **CHANGELOG.md** - Detailed version history
  - What changed in each version
  - Breaking changes highlighted
  - Migration instructions
  
- [ ] **UPGRADE.md** - Step-by-step upgrade guides
  - Version-specific instructions
  - Code migration examples
  - Common pitfalls
  
- [ ] **COMPATIBILITY.md** - Version matrix
  - Laravel version compatibility
  - PHP version requirements
  - Package version compatibility
  
- [ ] **UPDATING.md** - How to update guide
  - Different update methods
  - Backup strategies
  - Troubleshooting

### Real-World Update Examples

#### Example 1: Livewire 3 → 4 Update
```markdown
# Updating from Livewire 3 to 4

## Automated Updates
`php artisan starter:update --to=3.0`

## Manual Steps Required
1. Update component attributes
2. Replace compact() with direct property access
3. Update tests

## Breaking Changes
- Component render methods no longer use compact()
- New #[Layout] attribute required
```

#### Example 2: Adding New Feature
```markdown
# Adding Two-Factor Authentication (v3.1)

## For New Installations
Included by default in v3.1+

## For Existing Projects
`php artisan starter:feature:install two-factor`

Or manually:
1. Run migration: `php artisan migrate`
2. Publish views: `php artisan vendor:publish --tag=2fa-views`
3. Update User model: Add TwoFactorAuthenticatable trait
```

### Testing Update Process

- [ ] **Create update test suite**
  - Test updates from each major version
  - Verify data integrity after update
  - Test rollback functionality
  
- [ ] **Update documentation tests**
  - Ensure UPGRADE.md instructions work
  - Test on fresh Laravel installations
  - Test on projects with modifications

### Module-Manager Package Enhancement Plan (Simplified)

Since we're following Laravel's native override pattern, we need MUCH LESS custom tooling. Most of what module-manager needs already exists in Laravel!

#### Required Enhancements for module-manager

**1. Module Publishing Command**
```bash
# Already exists and working! ✅
php artisan module:publish Post

# What it does:
# - Copies Modules/Post/ to user's customization space
# - Registers in modules_statuses.json
# - Updates autoload paths
```

**2. Module Diff Command**
```bash
# Already exists and working! ✅
php artisan module:diff Post

# Compares:
# - Package version (if moved to vendor)
# - Published/customized version
#
# Shows file-by-file differences
```

**3. Module Status Command**
```bash
# Already exists and working! ✅
php artisan module:status

# Shows:
# Module     Location      Customized
# Post       Modules/      Yes (user owns this)
# Category   Modules/      Yes (user owns this)
# Tag        Modules/      Yes (user owns this)
# Menu       Modules/      Yes (user owns this)
```

**4. Module Migrations Helper**
```bash
# ✅ Created: Feb 3, 2026
php artisan module:check-migrations

# Checks modules for new migrations
# Shows which haven't been run yet
# Provides publishing commands
```

**That's It!** 

No need for:
- ❌ Checksum tracking
- ❌ Change detection systems
- ❌ Smart merge algorithms
- ❌ File classification
- ❌ Module registries (use Packagist!)
- ❌ Update APIs

**Why?** Laravel already solved this! Just use:
- `composer update` for package modules
- `vendor:publish` for selective publishing
- `loadViewsFrom()` for automatic override resolution
- `mergeConfigFrom()` for config merging

#### Implementation Priority

**✅ Completed (Feb 3, 2026):**
- [x] `module:publish` command - Publish modules for customization
- [x] `module:status` command - Show module status
- [x] `module:diff` command - Show differences between versions (optional, nice-to-have)
- [x] `module:check-migrations` helper - Check for new migrations

**Next Steps (Phase 2 - Package Extraction):**
- [ ] Move modules from `Modules/` to `module-manager` package structure
- [ ] Test module extraction workflow
- [ ] Create migration guide for existing projects

**Future (if needed):**
- [ ] GUI for module management (Filament plugin?)
- [ ] Module marketplace (separate project)

### Success Metrics

Track update adoption and issues:
- Update success rate (%)
- Common update failures
- Time to update (average)
- User-reported issues
- Rollback frequency

### References & Inspiration

**Laravel Breeze Approach:**
- Scaffolds authentication files
- Users own the files after scaffolding
- Updates via new installation (compare & merge)
- Clear UPGRADE.md for breaking changes

**Laravel Jetstream Approach:**
- Published stubs and views
- Core logic in package
- Updates via composer
- Version-specific documentation

**Spatie Packages Approach:**
- Clear versioning and changelogs
- Migration guides for major updates
- Configuration publishing
- Maintain backward compatibility in minor versions

**Filament Approach:**
- Core as package, customizations separate
- Auto-upgrade commands where possible
- Detailed upgrade documentation
- Version-specific docs

---

## 💡 Practical Example: Module Customization & Updates (The Laravel Way)

### Scenario: You need custom Post functionality for a client project

**Phase 1: Choose Your Approach**

#### Option A: Light Customization (Views/Config Only)
```bash
# Just need to tweak the post listing view
php artisan vendor:publish --tag=post-views

# Edit: resources/views/vendor/post/index.blade.php
# Add client's branding, custom styling, etc.
```

**Result:**
- ✅ Package module stays in vendor (updateable)
- ✅ Your view in `resources/views/vendor/post/` overrides package
- ✅ `composer update` → Your views untouched, core logic updated
- ✅ Zero complexity

---

#### Option B: Medium Customization (Controller Extension)
```php
// Don't publish whole module, just extend the controller

// app/Http/Controllers/ClientPostController.php
namespace App\Http\Controllers;

use LaravelStarterModules\Post\Http\Controllers\PostController as BaseController;

class ClientPostController extends BaseController
{
    public function index()
    {
        // Client wants featured posts section
        $featured = Post::where('featured', true)->limit(5)->get();
        
        return view('post::index', [
            'posts' => Post::latest()->paginate(20),
            'featured' => $featured,
            'clientName' => 'Acme Corp',
        ]);
    }
    
    // All other methods (show, create, store, etc.) inherited from parent
}

// routes/web.php
Route::get('/blog', [ClientPostController::class, 'index']);
```

**Result:**
- ✅ Package module in vendor (updateable)
- ✅ Your controller extends, adds features
- ✅ `composer update` → Base controller updates, your extensions preserved
- ✅ Minimal code duplication

---

#### Option C: Heavy Customization (Full Module Ownership)
```bash
# Client needs extensive changes across the module
php artisan module:publish Post

# Creates: Modules/Post/ (complete copy)
# Now you can modify:
# - Controllers
# - Models
# - Views
# - Routes
# - Migrations
# - Everything!
```

**Result:**
- ✅ You own the module completely
- ✅ Make any changes needed
- ⚠️ You're responsible for updates (won't auto-update from package)
- ✅ Can use `php artisan module:diff Post` to see what changed in package

---

### Phase 2: Package Update is Released (v3.1.0)

**New in v3.1.0:**
- 🐛 Bug fix: Fixed XSS vulnerability in post titles
- ✨ New feature: Post scheduling
- 📝 New migration: `add_scheduled_at_to_posts`

**Update Process by Customization Level:**

#### For Option A (Published Views Only):
```bashmodule-manager

# Output:
# Updating nasirkhan/module-manager (v4.0.0 => v5.0
# Updating nasirkhan/laravel-starter-modules (v12.20.0 => v12.21.0)

# Check for new migrations
php artisan module:check-migrations

# Output:
# New migrations found:
# - post: 2026_01_30_add_scheduled_at_to_posts.php
#
# Publish: php artisan vendor:publish --tag=post-migrations

php artisan vendor:publish --tag=post-migrations
php artisan migrate
```

**Result:**
- ✅ Bug fixes applied automatically
- ✅ New features available
- ✅ Your custom views untouched
- ✅ New migration added
- ⏱️ Time: 2 minutes

---

#### For Option B (Controller Extension):
```bashmodule-manager
composer update nasirkhan/laravel-starter-modules

# Check if parent controller changed
# Review CHANGELOG.md for breaking changes

# If PostController signature changed, update your extension
```

**Example - Breaking Change Handling:**
```php
// CHANGELOG says: PostController::index() now requires $request parameter

// Update your controller:
public function index(Request $request)  // Added parameter
{
    $featured = Post::where('featured', true)->limit(5)->get();
    
    return view('post::index', [
        'posts' => Post::latest()->paginate($request->input('per_page', 20)),
        'featured' => $featured,
    ]);
}
```

**Result:**
- ✅ Bug fixes applied to parent
- ✅ New features available in parent
- ⚠️ May need minor adjustments if breaking changes
- ⏱️ Time: 5-10 minutes

---

#### For Option C (Full Module Ownership):
```bash
# First, see what changed in the package
php artisan module:diff Post

# Output:
# ┌─ Post Module Differences ──────────────────────┐
# │ Package: v3.1.0                                 │
# │ Your Module: v12.20.0 (customized)              │
# │                                                  │
# │ Changed Files:                                  │
# │ M Http/Controllers/PostController.php           │
# │   - store() method: Fixed XSS vulnerability    │
# │   - New method: schedule()                     │
# │                                                  │
# │ A Database/Migrations/2026_01_30_add_...php    │
# │   - New migration for scheduling feature       │
# │                                                  │
# │ M Models/Post.php                               │
# │   - New scope: scheduled()                     │
# │   - New accessor: isScheduled()                │
# └─────────────────────────────────────────────────┘

# Review changes manually
# Apply security fix to YOUR controller
# Copy new migration if you want scheduling
# Update your model if needed

composer update nasirkhan/module-manager
# (doesn't affect your Modules/Post/ - it's yours now)
```

**Result:**
- ⚠️ You must manually review and apply changes
- ✅ Full control over what you adopt
- ⏱️ Time: 30-60 minutes (depending on changes)

---

### Phase 3: Best Practices Learned

**Choose the Right Level:**
```bash
# Quick decision tree:

Only views/config changes?
→ vendor:publish --tag=post-views/config
→ Easiest updates

Logic changes in 1-2 methods?
→ Extend controller in app/
→ Clean, inherits bug fixes

Massive changes throughout?
→ module:publish Post
→ Full control, manual updates
```

**Stay Informed:**
```bash
# Always check these before updating:
- CHANGELOG.md
- UPGRADE.md  
- GitHub releases notes
```

**Version Pinning (Optional):**
```json
// composer.json - If you need stability
"nasirkhan/module-manager": "4.0.*"  // Stay on 4.0.x
// vs
"nasirkhan/module-manager": "^4.0"   // Allow 4.x updates
```

---

### Comparison: Old Approach vs Laravel-Native Approach

| Aspect | Old Approach (Custom Tracking) | Laravel-Native Approach |
|--------|-------------------------------|------------------------|
| **Complexity** | High (checksums, diff tracking, merge logic) | Low (built into Laravel) |
| **Learning Curve** | New custom system to learn | Already know from Laravel packages |
| **Maintenance** | Custom code to maintain | Laravel maintains it |
| **Reliability** | Depends on our implementation | Battle-tested by millions |
| **Update Safety** | Complex merge conflicts | Clear separation, no conflicts |
| **Developer Experience** | Unique to this project | Same as Spatie, Nova, Filament |
| **Future Proof** | We maintain forever | Laravel team maintains |

**Winner: Laravel-Native Approach** 🏆

Simple, proven, maintainable, and developers already know it!

---

## 1. Documentation & Onboarding Enhancements

### 1.1 Missing Critical Files
- [ ] **CHANGELOG.md** - Track version history and breaking changes (crucial for base starter)
- [ ] **CONTRIBUTING.md** - Guidelines for contributors
- [ ] **UPGRADE.md** - Migration guide when updating from older versions
- [ ] **.github/ISSUE_TEMPLATE/** - Standardized issue reporting templates
- [ ] **.github/PULL_REQUEST_TEMPLATE.md** - PR contribution guidelines

### 1.2 README Improvements
- [ ] Add badges for test coverage, code quality, and build status
- [ ] Include a "Quick Start" section (5 minutes to running app)
- [ ] Add troubleshooting section for common issues
- [ ] Create a feature comparison table (what's included vs what's not)
- [ ] Add screenshots/GIFs of the admin panel and frontend

### 1.3 Documentation Structure
Create `/docs` folder with organized guides:
- [ ] **INSTALLATION.md** - Detailed setup guide
- [ ] **CONFIGURATION.md** - All configuration options explained
- [ ] **DEPLOYMENT.md** - Production deployment guide
- [ ] **API.md** - API documentation (if applicable)
- [ ] **MODULES.md** - How to create and manage modules
- [ ] **CUSTOMIZATION.md** - Theming and customization guide

---

## 2. Development Environment & Tooling

### 2.1 Docker/Sail Updates
- [ ] **Update docker-compose.yml** - Currently references PHP 8.1, but project uses 8.3
- [ ] Add PostgreSQL service option (currently only MySQL)
- [ ] Include Mailhog/MailPit for email testing
- [ ] Add Redis configuration

### 2.2 Code Quality Tools
- [ ] **Add pint.json** - Configure Laravel Pint rules explicitly
- [ ] **Add PHPStan/Larastan** - Static analysis for better code quality
- [ ] Create pre-commit git hooks (Husky equivalent for PHP)
- [ ] Add code coverage configuration and reporting

### 2.3 IDE Support
- [ ] Add PHPStorm/VS Code workspace settings
- [ ] Create `.vscode/settings.json` with recommended settings
- [ ] Add `.vscode/extensions.json` with recommended extensions

---

## 3. Testing Infrastructure

### 3.1 Test Coverage
- [ ] Add **Pest** support (modern testing) alongside PHPUnit
- [ ] Create test coverage requirements (minimum 70-80%)
- [ ] Add **Dusk** for browser testing examples
- [ ] Add API testing examples
- [ ] Create factory and seeder tests

### 3.2 CI/CD Enhancements
Update GitHub Actions workflow:
- [ ] Add code style checks (Pint)
- [ ] Add static analysis (PHPStan)
- [ ] Test multiple PHP versions (8.2, 8.3)
- [ ] Test multiple databases (SQLite, MySQL, PostgreSQL)
- [ ] Add test coverage reporting
- [ ] Add deployment workflow examples

---

## 4. Starter Template Features

### 4.1 Configuration Management
- [ ] **Add config/starter.php** - Central configuration for starter-specific features
- [ ] Create environment-specific `.env` examples:
  - `.env.development`
  - `.env.staging`
  - `.env.production`
- [ ] Add configuration validator command

### 4.2 Installation Improvements
- [ ] Create **post-install wizard** (interactive setup via Artisan command)
- [ ] Add `php artisan app:install` command that:
  - Validates environment
  - Configures database
  - Runs migrations/seeders
  - Sets up admin user
  - Configures mail/cache/queue
- [ ] Add `php artisan app:reset` for fresh start

### 4.3 Updatability Features
- [ ] Create **version checker** - Check for starter updates
- [ ] Add `php artisan starter:update` command with:
  - Backup before update
  - Merge configuration changes
  - Run necessary migrations
  - Report breaking changes
- [ ] Version compatibility checker

---

## 5. Module System Enhancements

### 5.1 Module Architecture
- [ ] Create **base module class** with common functionality
- [ ] Add **module-specific configuration files**
- [ ] Implement **module activation/deactivation hooks**
- [ ] Create **module-specific service providers**
- [ ] Add **module testing structure**
- [ ] Add module dependency resolution
- [ ] Create module marketplace documentation
- [ ] Add module versioning support
- [ ] Implement module update mechanism
- [ ] Add module testing scaffold generator

### 5.2 Module Templates
- [ ] Improve module generator (`php artisan module:build`)
- [ ] Add more stub options:
  - API module template
  - CRUD module template
  - Livewire module template
  - Vue/React component modules
- [ ] Include test stubs with modules

---

## 6. Database & Migration Improvements

### 6.1 Database Structure
- [ ] **Standardize migration naming convention** (currently mixing 2024 and 2025 dates)
- [ ] Add **foreign key constraints** where appropriate
- [ ] Add **indexes** for frequently queried columns
- [ ] Consider **UUIDs** for public-facing IDs (already using Sqids)
- [ ] Add **database seeding validation**
- [ ] Create **migration rollback testing**

### 6.2 Security & Best Practices

### 6.2.1 Security Enhancements
- [ ] Add **security.txt** in public folder
- [ ] Implement **rate limiting** examples in routes
- [ ] Add **2FA (Two-Factor Authentication)** module
- [ ] Add **API token** management example
- [ ] Add **audit logging** for sensitive actions
- [ ] Create security checklist documentation
- [ ] Add **CSRF token validation** for all forms
- [ ] Implement **input sanitization** helpers
- [ ] Add **XSS protection** middleware
- [ ] Implement **content security policy** headers
- [ ] Add **password strength validation**

### 6.2.2 Performance
- [ ] Add **query optimization** guidelines
- [ ] Implement **caching strategy** examples
- [ ] Add **database indexing** recommendations
- [ ] Create performance monitoring setup guide
- [ ] Add **queue job** examples
- [ ] Implement **query optimization** (eager loading)
- [ ] Add **caching strategies** for frequently accessed data
- [ ] Implement **lazy loading** for images
- [ ] Add **pagination** for all list views

---

## 7. Frontend & Asset Management

### 7.1 Livewire 4 Standardization (CRITICAL)
- [ ] **Convert all Livewire components to v4 patterns**
  - [ ] Add `#[Layout]` attribute to all components
  - [ ] Add `#[Title]` attribute to all components
  - [ ] Add `#[Validate]` attribute for validation rules
  - [ ] Add `#[Locked]` attribute for non-reactive properties
  - [ ] Add type hints for all properties
  - [ ] Add `mount()` method for initialization
  - [ ] Remove `compact()` from `render()` methods
- [x] **Components requiring conversion:**
  - [x] `app/Livewire/Backend/UsersIndex.php` - ✅ Converted
  - [x] `app/Livewire/Frontend/Users/Profile.php` - ✅ Converted
  - [x] `app/Livewire/Frontend/Users/ProfileEdit.php` - ✅ Converted
  - [x] `app/Livewire/Frontend/Users/ChangePassword.php` - ✅ Converted
  - [x] `app/Livewire/Frontend/Users/Show.php` - ✅ Converted
  - [x] `Modules/Post/Livewire/Frontend/RecentPosts.php` - ✅ Converted & Moved
  - [x] `app/Livewire/Actions/Logout.php` - ✅ Already v4 compliant (Action class)
  - [x] `app/Livewire/Auth/ConfirmPassword.php` - ✅ Already v4 compliant
  - [x] `app/Livewire/Auth/ForgotPassword.php` - ✅ Already v4 compliant
  - [x] `app/Livewire/Auth/Register.php` - ✅ Already has #[Validate] attributes
  - [x] `app/Livewire/Auth/ResetPassword.php` - ✅ Already v4 compliant
  - [x] `app/Livewire/Auth/VerifyEmail.php` - ✅ Already v4 compliant
- [ ] **Update view files** to use `$this->property` instead of compacted variables
- [ ] **Create Livewire component style guide** with examples

### 7.2 Frontend Component Organization
- [ ] **Reorganize components by feature**
  - [ ] Auth components (auth-header, auth-session-status, auth-social-login)
  - [ ] Form components (button, input, dropdown, modal)
  - [ ] Layout components (app-layout, guest-layout)
  - [ ] Backend components (sidebar, header, breadcrumbs)
  - [ ] Frontend components (menu, card, badge)
- [ ] Create **component documentation** with props and slots
- [ ] Add **component prop validation**
- [ ] Implement **component composition** patterns
- [ ] Add **component testing** examples
- [ ] Add **Alpine.js** component examples
- [ ] Create reusable **Blade components** library
- [ ] Add **dark mode** toggle component
- [ ] Improve responsive design examples

### 7.2 Route Consistency
- [ ] **Convert all CRUD operations to Livewire**
  - [ ] Frontend user routes (POST/PATCH/DELETE in `FrontendUserController`)
  - [ ] Backend routes that still use controllers
  - [ ] Use `#[Locked]` for read-only data
  - [ ] Implement form validation with `#[Validate]`
  - [ ] Use `$this->redirect()` for navigation
- [ ] **Standardize route definitions**
  - [ ] Use Route::livewire() for all Livewire components
  - [ ] Create route naming convention guide
  - [ ] Add route group organization best practices

### 7.3 Build Tools
- [ ] Add **Vite** configuration examples
- [ ] Create **build:production** npm script
- [ ] Add asset versioning/cache busting documentation
- [ ] Add CSS/JS optimization guidelines

---

## 8. API & Integration

### 8.1 API Foundation
- [ ] Add **Laravel Sanctum** API authentication example
- [ ] Create API versioning structure (`/api/v1`, `/api/v2`)
- [ ] Add **API rate limiting** configuration
- [ ] Create API documentation (OpenAPI/Swagger)
- [ ] Add API testing examples

### 8.2 Third-Party Integrations
- [ ] Add webhook handling examples
- [ ] Create payment gateway integration guide
- [ ] Add cloud storage configuration examples (AWS S3, DO Spaces)
- [ ] Add search engine integration (Algolia, Meilisearch)

---

## 9. Monitoring & Logging

### 9.1 Application Monitoring
- [ ] Add **Laravel Telescope** integration guide
- [ ] Add **Laravel Pulse** for monitoring
- [ ] Create custom dashboard for key metrics
- [ ] Add error tracking integration guide (Sentry, Flare)

### 9.2 Logging Improvements
- [ ] Add structured logging examples
- [ ] Create log rotation configuration
- [ ] Add log aggregation guide
- [ ] Implement custom log channels

---

## 10. Deployment & Production

### 10.1 Deployment Guides
- [ ] Add **zero-downtime deployment** guide
- [ ] Create deployment checklist
- [ ] Add server requirements documentation
- [ ] Add **Laravel Forge** setup guide
- [ ] Add **Laravel Vapor** deployment guide
- [ ] Add manual deployment guide (VPS)

### 10.2 Production Optimization
- [ ] Add **opcache** configuration
- [ ] Create production `.env` template with security notes
- [ ] Add **supervisor** configuration for queues
- [ ] Add **nginx/Apache** configuration examples
- [ ] Create backup automation guide

---

## 11. Maintenance & Operations

### 11.1 Maintenance Commands
- [ ] Add `php artisan app:health-check` command
- [ ] Create database backup automation
- [ ] Add cleanup commands (old logs, cache, sessions)
- [ ] Create maintenance mode customization

### 11.2 Monitoring
- [ ] Add application health monitoring
- [ ] Create automated backup verification
- [ ] Add disk space monitoring
- [ ] Implement database backup scheduling

---

## 12. Community & Ecosystem

### 12.1 Community Building
- [ ] Add **Discord/Slack** community link
- [ ] Create **discussions** board on GitHub
- [ ] Add starter showcase (websites built with it)
- [ ] Create video tutorial series documentation

### 12.2 Ecosystem Integration
- [ ] Add Laravel ecosystem package recommendations
- [ ] Create compatibility matrix with popular packages
- [ ] Add integration examples with:
  - Laravel Nova
  - FilamentPHP
  - Laravel Jetstream
  - Inertia.js

---

## 🎯 Priority Matrix for v13 Release

### 🔴 Critical Priority (Core Technical Changes for v13)
| Task | Impact | Effort | Status |
|------|--------|--------|--------|
| **Complete Module-Manager Package Extraction (Phase 2)** | Critical | High | ⏳ Next - Move modules from Modules/ to module-manager package |
| **Implement Updateability Strategy (Phase 1-2)** | Critical | High | ✅ Phase 1 Done (Feb 3, 2026) |
| **Convert all CRUD routes to Livewire** | Critical | High | ⏳ Pending |
| **Standardize database migrations** | High | Medium | ⏳ Pending |
| **Add comprehensive test suite for module system** | High | High | 🔄 In Progress (ModulePublishingTest done) |
| **Create starter:update command** | High | High | ⏳ Pending |
| **Adopt Semantic Versioning** | Critical | Low | ✅ Done (v12.20.0) |
| **Convert all Livewire components to v4 patterns** | Critical | High | ✅ Done |
| Fix docker-compose.yml PHP version (8.1 → 8.3) | High | Low | ✅ Done |
| Create post-install setup command | High | Medium | ✅ Done |

### 🟡 High Priority (v13 Technical Enhancements)
| Task | Impact | Effort | Status |
|------|--------|--------|--------|
| **Implement module versioning system** | High | High | ⏳ Pending |
| **Build migration update system** | High | Medium | ⏳ Pending |
| **Improve CI/CD pipeline** | High | Medium | ⏳ Pending |
| **Add security implementations (2FA, rate limiting)** | High | High | ⏳ Pending |
| **Add API foundation structure (Sanctum)** | High | High | ⏳ Pending |
| **Add PHPStan/Larastan static analysis** | Medium | Low | ⏳ Pending |
| **Add performance monitoring** | Medium | Medium | ⏳ Pending |
| **Create comprehensive .env examples** | Medium | Low | ✅ Done (Feb 3, 2026) |
| **Add security best practices documentation** | High | Medium | ✅ Done (Feb 3, 2026) |
| **Create IDE helper files** | Medium | Low | ✅ Done (Feb 3, 2026) |

### 🟢 Medium Priority (Post v13 Release)
| Task | Impact | Effort | Status |
|------|--------|--------|--------|
| **Enhance module system** | Medium | High | ✅ Phase 1 Done (Feb 3, 2026) |
| Add Pest testing support | Low | Low | ⏳ Pending |
| Add payment gateway integration examples | Medium | Medium | ⏳ Pending |
| Add cloud storage configuration examples | Medium | Low | ⏳ Pending |
| Add search engine integration (Meilisearch) | Medium | Medium | ⏳ Pending |

### 🔵 Low Priority (Documentation & Community - Post v13)
| Task | Impact | Effort | Status |
|------|--------|--------|--------|
| Create deployment guides | Medium | Medium | ⏳ Pending |
| Add UPGRADE.md guide | High | Medium | ✅ Done |
| Add CONTRIBUTING.md | Medium | Low | ✅ Done |
| Create INSTALLATION.md | Medium | Medium | ✅ Done (LOCAL_DEVELOPMENT.md) |
| Add Laravel Telescope guide | Low | Low | ⏳ Pending |
| Create video tutorial docs | Low | High | ⏳ Pending |
| Add showcase websites | Low | Medium | ⏳ Pending |
| Add community links | Low | Low | ⏳ Pending |

---

## 📊 Progress Tracking

### Overall Statistics
- **Total Tasks:** 180+
- **Completed:** 31
- **In Progress:** 2
- **Pending:** 147+
- **Progress:** ~17%

### By Category
| Category | Total | Completed | Progress |
|----------|-------|-----------|----------|
| **Updateability Strategy** | 40 | 12 | 30% |
| Documentation | 20 | 7 | 35% |
| Development Environment | 11 | 3 | 27% |
| Testing | 11 | 3 | 27% |
| Starter Features | 12 | 2 | 17% |
| Module System | 13 | 6 | 46% |
| Database | 6 | 0 | 0% |
| Security | 16 | 3 | 19% |
| Frontend | 20 | 12 | 60% |
| API & Integration | 9 | 0 | 0% |
| Monitoring | 8 | 0 | 0% |
| Deployment | 11 | 1 | 9% |
| Maintenance | 8 | 0 | 0% |
| Community | 8 | 0 | 0% |

---

## 📝 Implementation Notes

### Version Strategy
- **Major versions:** Breaking changes, significant feature additions
- **Minor versions:** New features, backward compatible
- **Patch versions:** Bug fixes, documentation updates

### Update Process for Base Starter Users
1. Review CHANGELOG.md for breaking changes
2. Check UPGRADE.md for migration steps
3. Run `php artisan starter:update` (when implemented)
4. Test application thoroughly
5. Deploy following DEPLOYMENT.md guide

### Contributing to This Roadmap
To suggest improvements or update progress:
1. Open an issue with the `enhancement` label
2. Submit a PR updating this file with progress
3. Mark items as completed with ✅ and add completion date

---

## 🤝 Contributing

See [CONTRIBUTING.md](../CONTRIBUTING.md) for guidelines on contributing to these improvements.

---

## 📅 v13 Implementation Roadmap

### Phase 1: Foundation (✅ COMPLETED - Feb 3, 2026)
- [x] **Design and document updateability strategy** ✅ Done
- [x] **Create CHANGELOG.md and UPGRADE.md** ✅ Done
- [x] **Implement starter:install command** ✅ Done
- [x] **Adopt semantic versioning** ✅ Done (v12.20.0)
- [x] **Complete Livewire 4 component standardization** ✅ Done
- [x] **Module service providers with publishing infrastructure** ✅ Done
- [x] **Environment configuration templates** ✅ Done (.env.development, .env.staging, .env.production)
- [x] **Security best practices documentation** ✅ Done (SECURITY_BEST_PRACTICES.md)
- [x] **IDE helper setup** ✅ Done (Laravel IDE Helper configured)

### Phase 2: Module-Manager Package Extraction (🔄 IN PROGRESS)
- [ ] **Move core modules to module-manager package structure**
  - [ ] Extract Post module to vendor/nasirkhan/module-manager/src/Modules/Post
  - [ ] Extract Category module to vendor/nasirkhan/module-manager/src/Modules/Category
  - [ ] Extract Tag module to vendor/nasirkhan/module-manager/src/Modules/Tag
  - [ ] Extract Menu module to vendor/nasirkhan/module-manager/src/Modules/Menu
- [ ] **Update module-manager composer.json with auto-discovery**
- [ ] **Test module publishing workflow**
- [ ] **Create migration guide for existing projects**
- [ ] **Update tests to work with new structure**

### Phase 3: Route & Architecture Standardization (⏳ NEXT)
- [ ] **Convert all CRUD routes to Livewire components**
  - [ ] FrontendUserController operations (userProviderDestroy, etc.)
  - [ ] Backend user operations (change password, block/unblock, restore)
  - [ ] Settings controller operations
  - [ ] Notifications controller operations
- [ ] **Standardize database migrations**
  - [ ] Audit migration naming conventions
  - [ ] Add missing foreign key constraints
  - [ ] Add indexes for performance
  - [ ] Create database seeding validation

### Phase 4: Update Mechanism & Testing (⏳ PENDING)
- [ ] **Create starter:update command**
  - [ ] Backup functionality
  - [ ] Version checking
  - [ ] Breaking change detection
  - [ ] Automated migration runner
- [ ] **Build migration update system**
  - [ ] Module migration tracking
  - [ ] Migration conflict resolution
- [ ] **Implement module versioning system**
  - [ ] Version compatibility checking
  - [ ] Dependency resolution
- [ ] **Create comprehensive test suite**
  - [ ] Update process tests
  - [ ] Module extraction tests
  - [ ] Migration tests

### Phase 5: Security & Performance (⏳ PENDING)
- [ ] **Implement security enhancements**
  - [ ] 2FA (Two-Factor Authentication) module
  - [ ] Rate limiting implementation
  - [ ] Enhanced input sanitization
  - [ ] Security headers configuration
- [ ] **Add API foundation structure**
  - [ ] Laravel Sanctum integration
  - [ ] API versioning (v1, v2)
  - [ ] API rate limiting
  - [ ] OpenAPI/Swagger documentation
- [ ] **Performance optimizations**
  - [ ] Query optimization
  - [ ] Caching strategies
  - [ ] Lazy loading implementation
  - [ ] Database indexing

### Phase 6: CI/CD & Quality Tools (⏳ PENDING)
- [ ] **Enhance CI/CD pipeline**
  - [ ] Add Pint code style checks
  - [ ] Add PHPStan/Larastan static analysis
  - [ ] Test multiple PHP versions (8.2, 8.3)
  - [ ] Test multiple databases (SQLite, MySQL, PostgreSQL)
  - [ ] Add test coverage reporting
- [ ] **Add monitoring solutions**
  - [ ] Laravel Pulse integration
  - [ ] Application health checks
  - [ ] Performance monitoring

### Phase 7: v13 Release & Beyond (⏳ PENDING)
- [ ] **Final testing and validation**
- [ ] **Update all documentation**
- [ ] **Release v13.0.0**
- [ ] **Post-release: Documentation improvements** (Lower priority)
- [ ] **Post-release: Community building** (Lower priority)

---

## 📞 Feedback

Have suggestions for this roadmap? Open an issue on GitHub or contact the maintainers.

**Maintainer:** Nasir Khan Saikat (nasir8891@gmail.com)

---

## 🚀 Next Steps for v13 Release

### Immediate Focus: Phase 2 - Module-Manager Package Extraction

**Goal:** Move core modules (Post, Category, Tag, Menu) from `Modules/` to `module-manager` package structure.

#### Step 1: Prepare Module-Manager Package Structure
```bash
# In module-manager package:
vendor/nasirkhan/module-manager/
├── src/
│   ├── Commands/          (✅ Exists)
│   ├── Modules/           (⏳ To be created)
│   │   ├── Post/
│   │   ├── Category/
│   │   ├── Tag/
│   │   └── Menu/
│   └── ModuleServiceProvider.php (✅ Exists)
└── composer.json          (⏳ Needs auto-discovery update)
```

#### Step 2: Extract Modules One by One
1. **Post Module** (First, as it's most complex)
   - Move `Modules/Post/` → `module-manager/src/Modules/Post/`
   - Update namespace to `Nasirkhan\ModuleManager\Modules\Post`
   - Update service provider
   - Test publishing workflow
   - Update tests

2. **Category Module**
3. **Tag Module**
4. **Menu Module**

#### Step 3: Update Laravel Starter Application
- Remove `Modules/` directory
- Update composer.json to require updated module-manager
- Update tests
- Verify all functionality works

#### Step 4: Testing & Validation
- Test module publishing: `php artisan module:publish Post`
- Test module status: `php artisan module:status`
- Test module diff: `php artisan module:diff Post`
- Test migrations: `php artisan module:check-migrations`
- Run full test suite

### Following Phases (In Sequence)

**Phase 3:** Route & Architecture Standardization  
**Phase 4:** Update Mechanism & Testing  
**Phase 5:** Security & Performance  
**Phase 6:** CI/CD & Quality Tools  
**Phase 7:** v13 Release  

**Note:** Documentation improvements are lower priority and will be handled post-v13 release.

---

## 📋 Project Strengths to Maintain

- ✅ Modular architecture with clear Backend/Frontend separation
- ✅ Livewire 4.0 with modern attributes (#[Layout], #[Title], #[Validate], #[Locked])
- ✅ Role-based permissions system (Spatie)
- ✅ Social login integration (Google, Facebook, GitHub)
- ✅ Media library and backup systems
- ✅ Multi-language support (Bengali, English, Persian, Turkish, Vietnamese)
- ✅ Comprehensive helper functions
- ✅ Activity logging
- ✅ Dynamic menu system
- ✅ Dark mode support

---

*This is a living document. Updates will be made as improvements are completed or priorities change.*
