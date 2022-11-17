<p align="center"><img src="https://user-images.githubusercontent.com/396987/82162573-6940f500-98c7-11ea-974e-888b4f866c74.jpg" alt="Laravel Starter - A CMS like modular starter project built with Laravel"></p>

# Laravel Starter (based on Laravel 9.x)
**Laravel Starter** is a Laravel 9.x based simple starter project. Most of the commonly needed features of an application like Authentication, User and Role management Application Backend, Backup, Logviewer are available here. It is modular, so you can use this project as a base and build your own modules. You can use the same module in any of the `Laravel Starter` based projects. 

Please let me know your feedback and comments.

# Reporting a Vulnerability
If you discover any security related issues, please send an e-mail to Nasir Khan Saikat via nasir8891@gmail.com instead of using the issue tracker.

# Appplication Demo
Check the following demo project. It is just a straight installation of the project without any modification.

Demo URL: http://laravel.nasirkhn.com

```
User: super@admin.com
Pass: secret

User: user@user.com
Pass: secret

```

## Demo Data
If you want to test the application on you local with additional demo data you may use the following command. By using this you can truncate the `posts, categories, tags and comments` table and insert new demo data.

`--fresh` option will truncate the tables, without this command new set to data will be inserted only.

```

php artisan starter:insert-demo-data --fresh

```

# Custom Commands

We have created a number of custom commands for the project. The commands are listed below with a brief about the use of it.

## Create New module

To create a project use the following command, you have repalce the MODULE_NAME with the name of the module.

```php
php artisan module:build MODULE_NAME
```

You may want to use `--force` option to overwrite the existing module. if you use this option, it will replace all the exisitng files with the defalut stub files.

```php
php artisan module:build MODULE_NAME --force
```

## Clear All Cache

```bash
composer clear-all
```

this is a shortcut command clear all cache including config, route and more

## Code Style Fix

```bash
composer fix-cs
```

apply the code style fix by this command.

## Role - Permissiosn

A number of custom commands are available to add and update role-permissions. Please read the [Role - Permission Wiki page](https://github.com/nasirkhan/laravel-starter/wiki/Role-Permission), where you will find the list of commands with examples. 


# Features

The `Laravel Starter` comes with a number of features which are the most common in almost all the applications. It is a template project which means it is intended to build in a way that it can be used for other projects.

It is a modular application, and a number of modules are installed by default. It will be helpful to use it as a base for the future applications.

* Admin feature and public views are completely separated as `Backend` and `Frontend` namespace.
* Major feature are developed as `Modules`. Module like Posts, Comments, Tags are separated from the core features like User, Role, Permission


## Core Features

* User Authentication
* Social Login
  * Google
  * Facebook
  * Github
  * Build in a way adding more is much easy now
* User Profile with Avatar
  * Separate User Profile table
* Role-Permissions for Users
* Dynamic Menu System
* Language Switcher
* Localization enable across the porject
* Backend Theme
  * Bootstrap 5, CoreUI
  * Fontawesome 6
* Frontend Theme
  * Tailwind
  * Fontawesome 5
* Article Module
  * Posts
  * Categories
  * Tags
  * Comments
  * wysiwyg editor
  * File browser
* Application Settings
* External Libraries
  * Bootstrap 5
  * Fontawesome 6
  * CoreUI
  * Tailwind
  * Datatables
  * Select2
  * Date Time Picker
* Backup (Source, Files, Database as Zip)
* Log Viewer
* Notification
  * Dashboard and details view


# User Guide

## Installation

Follow the steps mentioned below to install and run the project. You may find more details about the installation in [Installation Wiki](https://github.com/nasirkhan/laravel-starter/wiki/Installation).

1. Clone or download the repository
2. Go to the project directory and run `composer install`
3. Create `.env` file by copying the `.env.example`. You may use the command to do that `cp .env.example .env`
4. Update the database name and credentials in `.env` file
5. Run the command `php artisan migrate --seed`
6. Link storage directory: `php artisan storage:link`
7. You may create a virtualhost entry to access the application or run `php artisan serve` from the project root and visit `http://127.0.0.1:8000`

*After creating the new permissions use the following commands to update cashed permissions.*

`php artisan cache:forget spatie.permission.cache`

## Docker and Laravel Sail
This project is configured with Laravel Sail (https://laravel.com/docs/9.x/sail). You can use all the docker functionalities here.

## Icons
FontAwesome & CoreUI Icons, two different font icon library is installed for the Backend theme and only FontAwesome for the Frontend. For both of the cases we used the free version. You may install the pro version separately for your own project.

* **FontAwesome** - https://fontawesome.com/search?m=free
* **CoreUI Icons** - https://icons.coreui.io/icons/


# Screenshots

__Home Page__

![Laravel Starter Home](https://user-images.githubusercontent.com/396987/164892584-733afddc-8eab-4152-bd4a-d9c2f9e312d5.png)

__Login Page__

![Laravel Starter Login](https://user-images.githubusercontent.com/396987/164892620-3b4c8b1b-81c8-4630-a39f-38dadff89a7d.png)

__Posts Page__

![Laravel Starter Posts Page](https://user-images.githubusercontent.com/396987/164892767-2f961466-e346-4990-a183-655ce5a6603b.png)

__Backend Dashboard__

![Backend Dashboard](https://user-images.githubusercontent.com/396987/164915155-c2984b18-ae96-408a-820a-cbcac2cceb10.png)

---

![List-Posts-Laravel-Starter](https://user-images.githubusercontent.com/396987/88519250-a0dcc380-d013-11ea-9dc5-9d731af611f1.jpg)

---

![Edit-Posts-Laravel-Starter](https://user-images.githubusercontent.com/396987/88519360-d1bcf880-d013-11ea-9f6c-b5d33912057f.jpg)
