# MiniAdmin

The goal of the project is to have a small admin/blog system into place that I can use for my personal projects. The project uses [AdminLTE](https://github.com/ColorlibHQ/AdminLTE) for the admin side and [Clean Blog](https://github.com/startbootstrap/startbootstrap-clean-blog) for the client side.

# Features

* Laravel 8
* AdminLTE 3 (with editable SCSS and JS modules)
* CleanBlog (with editable SCSS)
* Laravel Debug Bar
* Laravel IDE Helper
* Laravel Sail
* Spatie Roles and Permissions
* EasyMDE (Markdown Editor)
* Browser Tests (will include unit tests when I finally learn how to do them right)

# Installation 

* Clone the repository using `git clone`
* Create an `.env` file by copying `.env.example`
* Run `composer install`
* Generate an `APP_KEY` by running `php artisan key:generate`
* Link the storage using `php artisan storage:link`
* Run the migrations using `php artisan migrate:fresh --seed`
* Install the frontend libraries using `npm install`
* Compile the frontend assets using `npm run dev`

# Users

| Name | Role | Email | Password |
| ---- | ---- | ----- | -------- |
| Guest User | guest | guest@example.com | password |
| Admin User | admin | admin@example.com | password |
| Super User | super_admin | super@example.com | password |
