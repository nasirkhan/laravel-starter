<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

# Laravel Starter
Laravel 6.x based simple starter project to build all type of applications. Most of the commonly needed features are available here. It is modular, so you can use this project as a base and build your own modules. You can use the same module in any of the Laravel starter based projects. New features and functionalities are being added on a regular basis.

Please let me know your feedback and comments.

> Current Build Status

[![StyleCI](https://github.styleci.io/repos/105638882/shield)](https://github.styleci.io/repos/105638882)


# Demo

http://laravel.nasirkhn.com/

## Features

* Admin feature and public views are completely separated as `Backend` and `Frontend`.
* Major feature are developed as `Modules`. Module like Posts, Comments are separated from the core features like User, Role, Permission


### All features

* User Authentication
* Social Login
  * Facebook
  * Github
  * Build in a way adding more is much easy now
* User Profile with Avatar
  * Separate User Profile table
* Role-Permissions for Users
* Dynamic Menu System
* Backend Theme
  * Bootstrap 4, CoreUI
  * Fontawesome 5
* Frontend Theme
  * Bootstrap 4, Now UI Kit
  * Fontawesome 5
* Article Module
  * Posts
  * Categories
  * Tags
  * Comments
  * wysiwyg editor
  * file browser
* Application Settings
* External Libraries
  * Bootstrap 4
  * Fontawesome 5
  * CoreUI
  * Now UI Kit
  * Datatables
  * Select2
  * Date Time Picker
* Backup (Source, Files, Database as Zip)
* Log Viewer
* Newsletter
* Notification
  * Dashboard and details view
* RSS Feed

## Installation

Follow the steps mentioned below to install and run the project.

1. Clone or download the repository
2. Go to the project directory and run `composer install`
3. Create `.env` file by copying the `.env.example`. You may use the command to to that `cp .env.example .env`
4. Update the database name and credentials
5. Run the command `php artisan migrate -seed`
6. You may create a virtualhost entry to access the application or run `php artisan serve` and visit `http://127.0.0.1:8000`

### Set Module Permissions
1. Set Permissions for Posts, Categories, Tags: `php artisan article:create-permissions`
1. Set Permissions for Newsletter:  `php artisan newsletter:create-permissions`

*After creating the new permissions use the following commands to update cashed permissions.*

`php artisan cache:forget spatie.permission.cache`

### Seed Sample Data (Optional & should use only on testing)
1. Add sample data on Posts, Categories, Tags with the following command `php artisan article:create-sample-data`
1. Add sample data on Newsletter with the following command `php artisan newsletter:create-sample-data`


## Screenshots

__Home Page__

![Laravel Starter Home](https://user-images.githubusercontent.com/396987/67085331-74606500-f1c0-11e9-8187-99fe49134075.png)

__Login Page__

![Laravel Starter Login](https://user-images.githubusercontent.com/396987/67085329-74606500-f1c0-11e9-8669-3638e30cb449.png)

__Backend Dashboard__

![Backend Dashboard](https://user-images.githubusercontent.com/396987/66694968-4e2c5800-ecdc-11e9-82a6-585d2082f4d1.png)
