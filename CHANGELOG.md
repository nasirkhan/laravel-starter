# Changelog

All notable changes to Laravel Starter will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Updateability strategy implementation following Laravel's native override pattern
- Module publishing system for selective customization
- Livewire v4 component standardization
- Comprehensive CHANGELOG.md for version tracking
- UPGRADE.md guide for version migrations
- CONTRIBUTING.md for contributor guidelines
- `starter:install` command for streamlined setup
- Local package development support via composer path repository
- Module management commands (publish, status, diff)

### Changed
- Enhanced module-manager package with publishing capabilities
- Improved documentation structure

### Fixed
- Docker compose PHP version (8.1 → 8.3)

## [12.20.0] - 2026-01-26

### Added
- Laravel 12 support
- PHP 8.3 support
- Livewire 4.0 integration with modern attributes (#[Layout], #[Title], #[Validate], #[Locked])
- Modular architecture with clear Backend/Frontend separation
- Role-based permissions system (Spatie Laravel Permission)
- Social authentication integration (Google, Facebook, GitHub) via Laravel Socialite
- Multi-language support (Bengali, English, Farsi, Hindi, Turkish, Vietnamese)
- Activity logging system (Spatie Laravel Activitylog)
- Media library management (Spatie Laravel Medialibrary)
- Automated backup system (Spatie Laravel Backup)
- Dynamic menu system with hierarchical support
- Dark mode support throughout application
- Laravel Herd compatibility
- Comprehensive helper functions
- DataTables integration for data listing
- File manager integration (Laravel File Manager)
- Log viewer for application monitoring
- Tailwind CSS 3.x for modern styling
- Vite for asset bundling

### Features
- **Authentication & Authorization**
  - Laravel Breeze integration
  - Role and permission management
  - Social login (Google, Facebook, GitHub)
  - Email verification
  - Password reset functionality
  
- **User Management**
  - User CRUD operations
  - Profile management
  - Avatar upload
  - User roles and permissions
  - Activity tracking

- **Module System**
  - Post module with CRUD operations
  - Category module
  - Tag module  
  - Menu module with dynamic menu builder
  - Module generator command

- **Admin Panel**
  - Modern dashboard
  - User management interface
  - Role and permission management
  - Activity log viewer
  - Media library
  - Backup management
  - Settings management

- **Frontend**
  - Responsive design
  - Dark mode toggle
  - User profiles
  - Recent posts display
  - Multi-language support

### Technical
- PSR-12 coding standards (Laravel Pint)
- PHPUnit test framework
- GitHub Actions CI/CD pipeline
- Docker support via Laravel Sail
- Modular architecture for scalability
- Queue system ready
- Cache configuration
- Session management
- Mail configuration

### Developer Experience
- Artisan commands for common tasks
- Helper functions for common operations
- Comprehensive seeding system
- Factory classes for testing
- Clear directory structure
- Modular code organization

## [12.19.0 and earlier] - 2025

For previous version history, see [GitHub Releases](https://github.com/nasirkhan/laravel-starter/releases)

[Unreleased]: https://github.com/nasirkhan/laravel-starter/compare/v12.20.0...HEAD
[12.20.0]: https://github.com/nasirkhan/laravel-starter/releases/tag/v12.20.0
