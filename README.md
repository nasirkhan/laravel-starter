<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

# Laravel Starter
Laravel 5.6 based simple starter project.

> Current Build Status

[![StyleCI](https://github.styleci.io/repos/105638882/shield)](https://github.styleci.io/repos/105638882)


## Features

* User Authentication
* Social Login
  * Facebook
  * Github
* User Profile with Avatar
* Role-Permissions for users
* Backend Theme
  * Bootstrap 4, CoreUI
  * Fontawesome 5
* Frontend Theme
  * Bootstrap 4, Now UI Kit
  * Fontawesome 5
* Posts Module
  * wysiwyg editor
  * file browser
* Categories Module
* External Libraries
  * Bootstrap 4
  * Fontawesome 5
  * CoreUI
  * Now UI Kit
  * Datatables
  * Select2
  * Date Time Picker
  
## Installation

Follow the steps mentioned below to install and run the project. 

1. Clone or download the repository 
2. Go to the project directory and run `composer install`
3. Create `.env` file by copying the `.env.example`. You may use the command to to that `cp .env.example .env`
4. Update the database name and credentials 
5. Run the command `php artisan migrate -seed`
6. You may create a virtualhost entry to access the application or run `php artisan serve` and visit `http://127.0.0.1:8000`
