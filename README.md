<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

# Laravel Starter
Laravel 5.7 based simple starter project.

> Current Build Status

[![StyleCI](https://github.styleci.io/repos/105638882/shield)](https://github.styleci.io/repos/105638882)


## Features

* User Authentication
* Social Login
  * Facebook
  * Github
* User Profile with Avatar
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

![Laravel Starter Home](https://user-images.githubusercontent.com/396987/42303564-d533b1e2-8043-11e8-9672-ba557b36c079.png)

__Login Page__

![Laravel Starter Login](https://user-images.githubusercontent.com/396987/42303563-d33f0576-8043-11e8-8a46-b4af32320b69.png)

__Backend Dashboard__

![Backend Dashboard](https://user-images.githubusercontent.com/396987/42303738-6bbe11c0-8044-11e8-9952-37f5587e59fd.png)
