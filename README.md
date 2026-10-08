<p align="center"><img src="https://user-images.githubusercontent.com/396987/82162573-6940f500-98c7-11ea-974e-888b4f866c74.jpg" alt="Laravel Starter - A CMS like modular starter project built with the latest Laravel framework."></p>

# Laravel Starter (based on Laravel 13.x)
**Laravel Starter** is a Laravel 13.x based simple starter project. Most of the commonly needed features of an application like `Authentication`, `Authorisation`, `Users` and `Role management`, `Application Backend`, `Backup`, `Log viewer` are available here. It is modular, so you may use this project as a base and build your own modules. A module can be used in any `Laravel Starter` based project.
Here Frontend and Backend are completely separated with separate routes, controllers, and themes as well.

***Please let me know your feedback and comments.***

[![Latest Stable Version](https://img.shields.io/packagist/v/nasirkhan/laravel-starter?label=Stable)](https://packagist.org/packages/nasirkhan/laravel-starter) 
[![Total Downloads](https://img.shields.io/packagist/dt/nasirkhan/laravel-starter.svg?label=Downloads)](https://packagist.org/packages/nasirkhan/laravel-starter)
[![StyleCI Build](https://github.styleci.io/repos/105638882/shield?style=flat)](https://packagist.org/packages/nasirkhan/laravel-starter) 
[![License](https://img.shields.io/github/license/nasirkhan/laravel-starter?label=License)](https://packagist.org/packages/nasirkhan/laravel-starter) 
[![PHP Version Require](http://poser.pugx.org/nasirkhan/laravel-starter/require/php)](https://packagist.org/packages/nasirkhan/laravel-starter)
[![Nasir Khan Saikat](https://img.shields.io/badge/Powered%20By-Nasir%20Khan%20Saikat-ff2d20.svg)](https://nasirkhn.com)

# Application Demo
Check the following demo project. It is just a straight installation of the project without any modification.

Demo URL: https://laravel.nasirkhn.com

You may use the following account credentials to access the application backend.

```
User: super@admin.com
Pass: secret

User: user@user.com
Pass: secret

```

# Custom Commands

We have created a number of custom commands for the project. The commands are listed below with a brief about their use of it.

## Install / Setup

See the canonical [Installation](#installation) section below for the full setup flow and all supported options for `php artisan starter:install`.

## Update

After pulling changes from the repository, run:

```bash
php artisan starter:update
```

This runs `composer update`, checks for new module migrations, runs outstanding migrations, and clears all caches.

## Create New Module

To create a module use the following command, replacing `MODULE_NAME` with the name of your module.

```bash
php artisan module:build MODULE_NAME
```

You may want to use the `--force` option to overwrite an existing module. If you use this option, it will replace all the existing files with the default stub files.

```bash
php artisan module:build MODULE_NAME --force
```

## Clear All Cache

```bash
php artisan clear-all
```

or 

```bash
composer clear-all
```

This clears application caches including config, route, view, and permission cache.
If you prefer Composer scripts, `composer clear-all` is also available.

## Code Style Fix

We are now using `Laravel Pint` to make the code style stay as clean and consistent as the Laravel Framework. Use the following command to apply CS-Fix.

```bash
composer pint
```

Along with Laravel Pint, we are using `prettier` to format the blade templates. You can install the `prettier` extension in your favorite editor.
The following command will format the blade templates.

```bash
npm run format
```

`npm` is the supported package manager for this project. Avoid mixing `npm` and `yarn` lockfiles on the same checkout, especially on Windows, because native packages such as `esbuild` and Tailwind's platform binaries can fail to resolve or unlink cleanly after a mixed install.

If you are intentionally using `yarn`, remove the existing install state first so Yarn can rebuild it from scratch.

```bash
Remove-Item -Recurse -Force node_modules
Remove-Item -Force yarn.lock
yarn cache clean
yarn install
yarn format
```


## Image Lightbox (PhotoSwipe)

The backend uses [PhotoSwipe v5](https://photoswipe.com/) as a zero-dependency image lightbox. It replaces the jQuery-based Lightbox2 library that was used in earlier versions.

### How it works

PhotoSwipe is initialised globally in `resources/js/photoswipe.js` and called from `app-backend.js` on both `DOMContentLoaded` and `livewire:navigated`, so it works across Livewire page navigation.

Any element with the class `pswp-gallery` that contains one or more `<a>` tags is automatically picked up. Clicking a thumbnail opens the full image in an overlay with keyboard navigation, pinch-to-zoom on touch devices, and swipe gestures.

### Markup convention

Wrap your thumbnail link in a `pswp-gallery` container:

```html
<div class="pswp-gallery">
    <a href="/path/to/full.jpg" data-pswp-src="/path/to/full.jpg">
        <img src="/path/to/thumb.jpg" class="rounded img-thumbnail" alt="" />
    </a>
</div>
```

- `href` — fallback if JavaScript is disabled
- `data-pswp-src` — full-resolution image PhotoSwipe opens in the overlay
- `data-pswp-width` / `data-pswp-height` — optional; if omitted, dimensions are resolved automatically when the overlay opens

### Where it is used

| Location | Trigger |
|---|---|
| Module form views (Post, Category, Tag) | Thumbnail of the currently saved image shown beside the file input |
| Backend show pages | Any column whose value ends with an image extension (`.jpg`, `.png`, etc.) rendered by `show_column_value()` |

### Extending with plugins

The initialisation in `resources/js/photoswipe.js` is a self-contained function. Adding an official plugin requires two steps:

```bash
npm install photoswipe-dynamic-caption-plugin
```

```js
// resources/js/photoswipe.js
import PhotoSwipeDynamicCaption from 'photoswipe-dynamic-caption-plugin';
import 'photoswipe-dynamic-caption-plugin/photoswipe-dynamic-caption-plugin.css';

// inside initPhotoSwipe(), before lightbox.init():
new PhotoSwipeDynamicCaption(lightbox, { type: 'auto' });
```

The same pattern applies to the [Deep Zoom (tiled zoom) plugin](https://github.com/dimsemenov/photoswipe-deep-zoom-plugin).

## Role - Permissions

Several custom commands are available to add and update `role-permissions`. Please read the [Role - Permission Wiki page](https://github.com/nasirkhan/laravel-starter/wiki/Role-Permission), where you will find the list of commands with examples.


# Features

The `Laravel Starter` comes with several features which are the most common in almost all applications. It is a template project which means it is intended to be built in a way that it can be used for other projects.

It is a modular application, and some modules are installed by default. It will be helpful to use it as a base for future applications.

* Admin feature and public views are completely separated as `Backend` and `Frontend` namespace.
* Major features are developed as `Modules`. A module like Posts, Comments, and Tags are separated from the core features like User, Role, Permission


## Core Features

* User Authentication
* Social Login
  * Google
  * Facebook
  * Github
  * Each provider can be toggled independently via `GOOGLE_ACTIVE`, `FACEBOOK_ACTIVE`, `GITHUB_ACTIVE` env variables (default: `false`). The login page shows only the active providers.
  * Adding more providers is straightforward
* User Profile with Avatar
* Role-Permissions for Users
* Dynamic Menu System
* Language Switcher
* Localization enabled across the project
* Backend Theme
  * Tailwind CSS v4, Flowbite
  * Fontawesome 7
  * Dark Mode
  * Livewire-powered tables
* Frontend Theme
  * Tailwind CSS v4
  * Fontawesome 7
  * Dark Mode
* Article Module
  * Posts
  * Categories
  * Tags
  * Comments
  * WYSIWYG editor ([laravel-jodit](https://github.com/nasirkhan/laravel-jodit))
  * File browser
* Application Settings
* External Libraries
  * Tailwind CSS v4
  * Flowbite
  * Fontawesome 7
  * Tom Select
  * Jodit WYSIWYG Editor
  * PhotoSwipe (image lightbox)
* Backup (Source, Files, Database as Zip)
* Log Viewer
* Notification
  * Dashboard and details view


## Companion Packages

Laravel Starter is built on top of a set of focused, reusable packages that are also available independently for any Laravel application.

| Package | Description |
|---|---|
| [nasirkhan/laravel-admin](https://github.com/nasirkhan/laravel-admin) | Tailwind CSS v4 / Flowbite backend shell — sidebar, header, breadcrumb layout, and Livewire-powered CRUD for users, roles, and notifications |
| [nasirkhan/module-manager](https://github.com/nasirkhan/module-manager) | Powerful module management with version tracking, migration management, dependency resolution, and full module lifecycle commands (`module:status`, `module:build`, `module:enable`, etc.) |
| [nasirkhan/laravel-cube](https://github.com/nasirkhan/laravel-cube) | Versatile collection of reusable UI Blade components (buttons, modals, cards, forms, navigation, and more) with dual Tailwind CSS and Bootstrap 5 support and built-in dark mode |
| [nasirkhan/laravel-jodit](https://github.com/nasirkhan/laravel-jodit) | Integrates the [Jodit](https://xdsoft.net/jodit/) WYSIWYG editor via a single Blade component (`<x-jodit::editor>`), with Livewire support and a built-in server-side file browser/uploader |
| [nasirkhan/laravel-sharekit](https://github.com/nasirkhan/laravel-sharekit) | Reusable Blade-powered social sharing buttons with metadata auto-detection, popup sharing, native Web Share API support, copy-link action, and page-scoped asset loading |


# User Guide

## Installation

This is the single source of truth for installing Laravel Starter from a fresh checkout. You may find more background in the [Installation Wiki](https://github.com/nasirkhan/laravel-starter/wiki/Installation).

### From GitHub Template (recommended)

If you created a new repository from this GitHub template, or cloned it directly:

```bash
# 1. Install PHP dependencies
composer install

# 2. Run the interactive setup wizard — handles .env, database, migrations, seeding, and npm assets
php artisan starter:install
```

Or as a single shortcut after `composer install`:

```bash
composer setup
```

For a true one-liner from a fresh clone, convenience scripts are included:

```bash
# Linux / macOS
bash setup.sh

# Windows (PowerShell)
.\setup.ps1
```

Both scripts run `composer install` and then launch `php artisan starter:install`.
Pass any `starter:install` flags through, e.g. `bash setup.sh --demo`.

The setup wizard will guide you through environment configuration, database selection, migrations, seeding, and building frontend assets. When finished it prints the app URL and default login credentials.

**Available options:**

| Option | Description |
|---|---|
| `--skip-db` | Skip database setup |
| `--skip-seed` | Skip database seeding |
| `--skip-npm` | Skip `npm install` and asset build |
| `--demo` | Seed with demo data (no prompt) |

If you only need to rerun cache clearing after setup, use:

```bash
php artisan clear-all
```

### Via Composer create-project

```bash
composer create-project nasirkhan/laravel-starter
```

This runs migrations automatically. Afterwards run the setup wizard to seed and build assets:

```bash
php artisan starter:install --skip-db
```

*After creating the new permissions use the following commands to update cached permissions.*

`php artisan cache:forget spatie.permission.cache`

## Database Seeding

Two seeder categories are available:

- **Essential** (always run): users, roles, permissions, menu — `AuthTableSeeder`, `MenuDatabaseSeeder`
- **Dummy data** (optional): posts, categories, tags — disabled via `SEED_DUMMY_DATA=false` in `.env`

```bash
# Full seed (essential + dummy data)
php artisan migrate:fresh --seed

# Essential data only
php artisan db:seed-essential --fresh

# Add or refresh demo content at any time
php artisan laravel-starter:insert-demo-data
php artisan laravel-starter:insert-demo-data --fresh
```

For production, set `SEED_DUMMY_DATA=false` and use `--force`:
```bash
php artisan db:seed-essential --fresh --force
```

## Docker and Laravel Sail
This project is configured with [Laravel Sail](https://laravel.com/docs/sail). You can use all the docker functionalities here. To install using docker and sail:

1. Clone or download the repository
2. Go to the project directory and run `composer install`
3. Create `.env` file by copying the `.env-sail`. You may use the command to do that `cp .env-sail .env`
4. Update the database name and credentials in `.env` file
5. Run the command `sail up` (consider adding this to your alias: `alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'`)
6. Run the command `sail artisan migrate --seed`
7. Link storage directory: `sail artisan storage:link`
8. Since Sail is already up, you can just visit http://localhost:80


# Reporting a Vulnerability
If you discover any security-related issues, please send an e-mail to Nasir Khan Saikat via nasir8891@gmail.com instead of using the issue tracker.


# Screenshots

__Home Page__

<img alt="home dark" src="https://github.com/user-attachments/assets/fb57889b-b2d0-4995-8ab0-52718fc821a1" />
<img alt="home light" src="https://github.com/user-attachments/assets/96f4392a-6fe8-49ab-83a7-a0458cca6295" />

__Login Page__

<img alt="login dark" src="https://github.com/user-attachments/assets/99b27a34-3139-4762-a535-a771dd5b14c3" />
<img alt="login light" src="https://github.com/user-attachments/assets/89b2f7b5-56f1-47ff-9e90-220597bb1121" />

__Backend Dashboard__

<img alt="dashboard dark" src="https://github.com/user-attachments/assets/9bc02ce0-9035-4315-a14d-5477c020f383" />
<img alt="dashboard light" src="https://github.com/user-attachments/assets/0e1a2097-8d47-42e4-bae3-874d3c5bcd03" />

__Backend Settings__

<img alt="settings dark" src="https://github.com/user-attachments/assets/6f443dd1-9098-417f-ba88-bbb880949cde" />
<img alt="settings light" src="https://github.com/user-attachments/assets/fcf5c24d-fa8c-465b-b3c2-8f9a0a691c43" />

__Posts Page__

<img alt="post dark" src="https://github.com/user-attachments/assets/41b791be-1e52-479c-ab64-ef657126842f" />
<img alt="posts light" src="https://github.com/user-attachments/assets/d1dc8bc5-c048-4a60-b8d5-90994e7e8c00" />
