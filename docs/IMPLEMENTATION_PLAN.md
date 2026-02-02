# Laravel Starter Updateability - Implementation Plan

**Created:** February 2, 2026  
**Status:** In Progress

This document outlines the step-by-step implementation plan for making Laravel Starter updateable, following Laravel's native override pattern.

---

## 🎯 Project Structure

- **Laravel Starter:** `C:\Users\Nasir Khan\Herd\laravel-starter`
- **Module Manager:** `C:\Users\Nasir Khan\Herd\module-manager`

---

## 📋 Implementation Phases

### Phase 1: Local Development Setup ✅

#### 1.1 Link Local Package
```bash
cd "C:\Users\Nasir Khan\Herd\laravel-starter"

# Add path repository to composer.json
composer config repositories.module-manager path "../module-manager"

# Update to use local version
composer require nasirkhan/module-manager:@dev
```

**Result:** Changes to module-manager will immediately reflect in laravel-starter.

---

### Phase 2: Foundation Files (Week 1)

#### 2.1 Create CHANGELOG.md ⏳
**Location:** `laravel-starter/CHANGELOG.md`

```markdown
# Changelog

All notable changes to Laravel Starter will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Updateability strategy implementation
- Module publishing system
- Livewire v4 standardization

## [12.20.0] - Latest

### Added
- Laravel 12 support
- PHP 8.3 support
- Livewire 4.0 integration
- Modular architecture
- Role-based permissions (Spatie)
- Social login (Google, Facebook, GitHub)
- Multi-language support (including Turkish)
- Activity logging
- Media library and backups
- Dynamic menu system
- Dark mode support
- Log viewer integration

[Unreleased]: https://github.com/nasirkhan/laravel-starter/compare/v12.20.0...HEAD
[12.20.0]: https://github.com/nasirkhan/laravel-starter/releases/tag/v12.20.0
```

#### 2.2 Create UPGRADE.md ⏳
**Location:** `laravel-starter/UPGRADE.md`

```markdown
# Upgrade Guide

This guide provides instructions for upgrading between major versions of Laravel Starter.

## Table of Contents
- [Upgrading to 13.x from 12.x](#upgrading-to-13x-from-12x)
- [Current Version](#current-version-1220)

---

## Current Version: 12.20.0

The current stable version is v12.20.0, based on Laravel 12.x with PHP 8.3 support.

### Key Features
- Laravel 12.x framework
- PHP 8.3 support
- Livewire 4.0 integration
- Modular architecture
- Role-based permissions (Spatie)
- Social login (Google, Facebook, GitHub)
- Multi-language support
- Log viewer integration
- Dark mode support

---

## Upgrading to 13.x from 12.x

> **Estimated Time:** 30-60 minutes  
> **Note:** This is for future upgrades when 13.x is released

### Requirements
- PHP 8.3+
- Laravel 13+
- Composer 2.0+

### Planned High Impact Changes
- Module system refactored to package-based architecture
- Configuration publishing system introduced
- View override patterns changed

### Step-by-Step Guide

#### 1. Update Dependencies
```bash
composer update nasirkhan/module-manager
php artisan view:clear
php artisan config:clear
```

#### 2. Publish New Configuration
```bash
php artisan vendor:publish --tag=module-manager-config
```

#### 3. Check Module Status
```bash
php artisan module:status
```

#### 4. Update Custom Modules
If you've customized any default modules, review changes:
```bash
php artisan module:diff Post
php artisan module:diff Category
```

#### 5. Run Tests
```bash
php artisan test
```

### Planned Breaking Changes

#### Module Resolution
**Current (12.x):**
```php
// Modules in Modules/ directory
use Modules\Post\Models\Post;
```

**Future (13.x):**
```php
// Modules in vendor by default, can be published
use Nasirkhan\ModuleManager\Modules\Post\Models\Post;
// Or if published:
use Modules\Post\Models\Post;
```

### Low Impact Changes
- Minor configuration changes
- View path adjustments
```

#### 2.3 Create CONTRIBUTING.md ⏳
**Location:** `laravel-starter/CONTRIBUTING.md`

```markdown
# Contributing to Laravel Starter

Thank you for considering contributing to Laravel Starter!

## Code of Conduct
Be respectful and constructive.

## How Can I Contribute?

### Reporting Bugs
- Use GitHub Issues
- Include Laravel/PHP versions
- Provide reproduction steps

### Suggesting Enhancements
- Use GitHub Discussions
- Explain use case clearly
- Provide examples if possible

### Pull Requests
1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Write/update tests
5. Run `composer pint` for code style
6. Submit PR with clear description

## Development Setup

```bash
git clone https://github.com/nasirkhan/laravel-starter.git
cd laravel-starter
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install && npm run dev
```

## Coding Standards
- Follow PSR-12
- Use Laravel best practices
- Add PHPDoc blocks
- Write tests for new features

## Testing
```bash
php artisan test
```

Thank you! 🙏
```

---

### Phase 3: Module Manager Package Changes (Week 1-2)

This requires changes to `C:\Users\Nasir Khan\Herd\module-manager`

#### 3.1 Package Structure Enhancement

**Create new directory structure:**
```
module-manager/
├── src/
│   ├── Commands/
│   │   ├── ModuleBuildCommand.php (existing)
│   │   ├── ModulePublishCommand.php (NEW)
│   │   ├── ModuleStatusCommand.php (NEW)
│   │   ├── ModuleDiffCommand.php (NEW)
│   │   └── ModuleCheckMigrationsCommand.php (NEW)
│   ├── Modules/ (NEW - Default starter modules)
│   │   ├── Post/
│   │   │   ├── PostServiceProvider.php
│   │   │   ├── Http/Controllers/
│   │   │   ├── Models/
│   │   │   ├── Resources/views/
│   │   │   ├── Config/config.php
│   │   │   └── Database/Migrations/
│   │   ├── Category/
│   │   ├── Tag/
│   │   └── Menu/
│   └── ModuleManagerServiceProvider.php (enhanced)
├── composer.json (updated)
└── README.md
```

#### 3.2 Commands to Create

**File:** `module-manager/src/Commands/ModulePublishCommand.php`
```php
<?php

namespace Nasirkhan\ModuleManager\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ModulePublishCommand extends Command
{
    protected $signature = 'module:publish {module : The name of the module to publish}';
    protected $description = 'Publish a module from vendor to Modules directory for customization';

    public function handle()
    {
        $moduleName = $this->argument('module');
        $sourcePath = base_path("vendor/nasirkhan/module-manager/src/Modules/{$moduleName}");
        $destinationPath = base_path("Modules/{$moduleName}");

        if (!File::exists($sourcePath)) {
            $this->error("Module '{$moduleName}' not found in package.");
            return 1;
        }

        if (File::exists($destinationPath)) {
            if (!$this->confirm("Module '{$moduleName}' already exists. Overwrite?")) {
                return 0;
            }
            File::deleteDirectory($destinationPath);
        }

        File::copyDirectory($sourcePath, $destinationPath);
        
        // Update modules_statuses.json
        $this->updateModuleStatus($moduleName, true);

        $this->info("Module '{$moduleName}' published successfully!");
        $this->line("Location: {$destinationPath}");
        $this->warn("Note: This module is now user-owned and won't be updated via composer.");
        
        return 0;
    }

    protected function updateModuleStatus(string $module, bool $published): void
    {
        $statusFile = base_path('modules_statuses.json');
        $statuses = File::exists($statusFile) 
            ? json_decode(File::get($statusFile), true) 
            : [];

        $statuses[$module] = [
            'published' => $published,
            'published_at' => now()->toISOString(),
            'location' => 'user',
        ];

        File::put($statusFile, json_encode($statuses, JSON_PRETTY_PRINT));
    }
}
```

**File:** `module-manager/src/Commands/ModuleStatusCommand.php`
```php
<?php

namespace Nasirkhan\ModuleManager\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ModuleStatusCommand extends Command
{
    protected $signature = 'module:status';
    protected $description = 'Show status of all modules (package vs published)';

    public function handle()
    {
        $packageModules = $this->getPackageModules();
        $publishedModules = $this->getPublishedModules();
        
        $rows = [];
        
        foreach ($packageModules as $module) {
            $isPublished = in_array($module, $publishedModules);
            $location = $isPublished ? 'Modules/ (custom)' : 'vendor (package)';
            $customized = $isPublished ? '⚠ Yes' : '✓ No';
            
            $rows[] = [
                $module,
                $location,
                $customized,
                $isPublished ? 'User owns this' : 'Updateable via composer',
            ];
        }

        $this->table(
            ['Module', 'Location', 'Customized', 'Update Strategy'],
            $rows
        );

        $this->newLine();
        $this->info('To publish a module for customization: php artisan module:publish {module}');
        $this->info('To see differences: php artisan module:diff {module}');
    }

    protected function getPackageModules(): array
    {
        $path = base_path('vendor/nasirkhan/module-manager/src/Modules');
        if (!File::exists($path)) {
            return [];
        }

        return collect(File::directories($path))
            ->map(fn($dir) => basename($dir))
            ->toArray();
    }

    protected function getPublishedModules(): array
    {
        $path = base_path('Modules');
        if (!File::exists($path)) {
            return [];
        }

        return collect(File::directories($path))
            ->map(fn($dir) => basename($dir))
            ->toArray();
    }
}
```

**File:** `module-manager/src/Commands/ModuleDiffCommand.php`
```php
<?php

namespace Nasirkhan\ModuleManager\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

class ModuleDiffCommand extends Command
{
    protected $signature = 'module:diff {module : The module to compare}';
    protected $description = 'Show differences between package and published module';

    public function handle()
    {
        $moduleName = $this->argument('module');
        $packagePath = base_path("vendor/nasirkhan/module-manager/src/Modules/{$moduleName}");
        $publishedPath = base_path("Modules/{$moduleName}");

        if (!File::exists($packagePath)) {
            $this->error("Module '{$moduleName}' not found in package.");
            return 1;
        }

        if (!File::exists($publishedPath)) {
            $this->warn("Module '{$moduleName}' has not been published yet.");
            $this->info("It's using the package version (updateable via composer).");
            return 0;
        }

        $this->info("Comparing package version with your customized version...");
        $this->newLine();

        // Simple file comparison
        $packageFiles = $this->getFileList($packagePath);
        $publishedFiles = $this->getFileList($publishedPath);

        $onlyInPackage = array_diff($packageFiles, $publishedFiles);
        $onlyInPublished = array_diff($publishedFiles, $packageFiles);
        $common = array_intersect($packageFiles, $publishedFiles);

        if (!empty($onlyInPackage)) {
            $this->warn("New files in package (not in your version):");
            foreach ($onlyInPackage as $file) {
                $this->line("  + {$file}");
            }
            $this->newLine();
        }

        if (!empty($onlyInPublished)) {
            $this->info("Files only in your version:");
            foreach ($onlyInPublished as $file) {
                $this->line("  - {$file}");
            }
            $this->newLine();
        }

        $this->info("Consider manually reviewing and merging package changes if needed.");
        
        return 0;
    }

    protected function getFileList(string $path): array
    {
        return collect(File::allFiles($path))
            ->map(fn($file) => str_replace($path . DIRECTORY_SEPARATOR, '', $file->getPathname()))
            ->toArray();
    }
}
```

#### 3.3 Update ModuleManagerServiceProvider

**File:** `module-manager/src/ModuleManagerServiceProvider.php`
```php
<?php

namespace Nasirkhan\ModuleManager;

use Illuminate\Support\ServiceProvider;
use Nasirkhan\ModuleManager\Commands\ModuleBuildCommand;
use Nasirkhan\ModuleManager\Commands\ModulePublishCommand;
use Nasirkhan\ModuleManager\Commands\ModuleStatusCommand;
use Nasirkhan\ModuleManager\Commands\ModuleDiffCommand;

class ModuleManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Merge config
        $this->mergeConfigFrom(__DIR__.'/../config/module-manager.php', 'module-manager');
    }

    public function boot(): void
    {
        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                ModuleBuildCommand::class,
                ModulePublishCommand::class,
                ModuleStatusCommand::class,
                ModuleDiffCommand::class,
            ]);

            // Publish config
            $this->publishes([
                __DIR__.'/../config/module-manager.php' => config_path('module-manager.php'),
            ], 'module-manager-config');
        }

        // Auto-register module service providers
        $this->registerPackageModules();
    }

    protected function registerPackageModules(): void
    {
        $modulesPath = __DIR__.'/Modules';
        
        if (!is_dir($modulesPath)) {
            return;
        }

        $modules = scandir($modulesPath);
        
        foreach ($modules as $module) {
            if (in_array($module, ['.', '..'])) {
                continue;
            }

            $providerClass = "Nasirkhan\\ModuleManager\\Modules\\{$module}\\{$module}ServiceProvider";
            
            if (class_exists($providerClass)) {
                $this->app->register($providerClass);
            }
        }
    }
}
```

---

### Phase 4: Laravel Starter Changes (Week 2)

#### 4.1 Update composer.json

Add path repository and update autoload:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "../module-manager"
        }
    ],
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Modules\\": "Modules/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        }
    }
}
```

#### 4.2 Create starter:install Command

**File:** `app/Console/Commands/StarterInstallCommand.php`

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class StarterInstallCommand extends Command
{
    protected $signature = 'starter:install';
    protected $description = 'Install and configure Laravel Starter';

    public function handle()
    {
        $this->info('╔═══════════════════════════════════════╗');
        $this->info('║   Laravel Starter Installation       ║');
        $this->info('╚═══════════════════════════════════════╝');
        $this->newLine();

        // Environment setup
        if ($this->setupEnvironment()) {
            // Database setup
            if ($this->setupDatabase()) {
                // Run migrations
                if ($this->runMigrations()) {
                    // Create admin user
                    $this->createAdminUser();
                    
                    $this->newLine();
                    $this->info('✓ Installation completed successfully!');
                    $this->info('→ Run: php artisan serve');
                    $this->info('→ Visit: http://localhost:8000');
                }
            }
        }

        return 0;
    }

    protected function setupEnvironment(): bool
    {
        $this->info('→ Setting up environment...');
        
        if (!file_exists(base_path('.env'))) {
            copy(base_path('.env.example'), base_path('.env'));
            Artisan::call('key:generate', [], $this->output);
            $this->line('  ✓ Environment file created');
        } else {
            $this->line('  ✓ Environment file already exists');
        }

        return true;
    }

    protected function setupDatabase(): bool
    {
        $this->info('→ Configuring database...');
        
        $dbType = $this->choice(
            'Select database type',
            ['SQLite', 'MySQL', 'PostgreSQL'],
            0
        );

        if ($dbType === 'SQLite') {
            $dbPath = database_path('database.sqlite');
            if (!file_exists($dbPath)) {
                touch($dbPath);
            }
            $this->updateEnvFile('DB_CONNECTION', 'sqlite');
            $this->line('  ✓ SQLite database configured');
        } else {
            // Interactive DB configuration for MySQL/PostgreSQL
            $this->line('  ℹ Please configure database in .env file manually');
        }

        return true;
    }

    protected function runMigrations(): bool
    {
        $this->info('→ Running migrations...');
        
        if ($this->confirm('Run database migrations?', true)) {
            Artisan::call('migrate:fresh', [], $this->output);
            
            if ($this->confirm('Seed database with sample data?', true)) {
                Artisan::call('db:seed', [], $this->output);
            }
            
            $this->line('  ✓ Migrations completed');
            return true;
        }

        return false;
    }

    protected function createAdminUser(): void
    {
        $this->info('→ Admin user should be created via seeding');
        $this->line('  Default credentials: admin@admin.com / secret');
    }

    protected function updateEnvFile(string $key, string $value): void
    {
        $envFile = base_path('.env');
        $content = file_get_contents($envFile);
        
        $pattern = "/^{$key}=.*/m";
        $replacement = "{$key}={$value}";
        
        if (preg_match($pattern, $content)) {
            $content = preg_replace($pattern, $replacement, $content);
        } else {
            $content .= "\n{$replacement}";
        }
        
        file_put_contents($envFile, $content);
    }
}
```

Register command in `app/Console/Kernel.php` or `bootstrap/app.php` (Laravel 12).

---

### Phase 5: Testing & Documentation (Week 3)

#### 5.1 Create Test Suite
- Test module:publish command
- Test module:status command
- Test module:diff command
- Test starter:install command

#### 5.2 Update Documentation
- Complete README.md updates
- Add INSTALLATION.md
- Add CUSTOMIZATION.md

---

## 🚀 Quick Start

### Step 1: Setup Local Development

```bash
cd "C:\Users\Nasir Khan\Herd\laravel-starter"

# Link local package
composer config repositories.module-manager path "../module-manager"
composer require nasirkhan/module-manager:@dev

# Install dependencies
composer install
```

### Step 2: Create Foundation Files
```bash
# These will be created via this implementation
# - CHANGELOG.md
# - UPGRADE.md
# - CONTRIBUTING.md
```

### Step 3: Work on Module Manager
Apply changes from Phase 3 to:
`C:\Users\Nasir Khan\Herd\module-manager`

### Step 4: Test Integration
```bash
cd "C:\Users\Nasir Khan\Herd\laravel-starter"

# Test new commands
php artisan module:status
php artisan module:publish Post
php artisan module:diff Post
php artisan starter:install
```

---

## 📝 Next Steps

1. ✅ Review this implementation plan
2. ⏳ Approve approach
3. ⏳ Begin Phase 1: Foundation files
4. ⏳ Implement module-manager changes
5. ⏳ Create tests
6. ⏳ Update documentation

---

## 🤔 Decision Points

### Should we move modules to package immediately?
**Recommendation:** Do it in phases
- Phase 1: Commands and infrastructure
- Phase 2: Move one module (Post) as proof of concept
- Phase 3: Move remaining modules

### Should we support both vendor and Modules/?
**Recommendation:** Yes
- Vendor: Default, updateable
- Modules/: Published, user-owned
- Laravel auto-resolution handles both

---

## 🎯 Success Criteria

- [ ] Can link local package for development
- [ ] Can publish a module from package to Modules/
- [ ] Can see module status (package vs published)
- [ ] Can see differences between versions
- [ ] Installation command works end-to-end
- [ ] All documentation created
- [ ] Tests passing

---

**Questions? Discuss before proceeding with implementation.**
