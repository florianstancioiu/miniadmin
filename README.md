# MiniAdmin

A Laravel based project by Florian Stancioiu

The goal of the project is to have a small admin system into place that I can use for my personal projects. The Admin uses [AdminLTE](https://github.com/ColorlibHQ/AdminLTE) for the admin side and [Clean Blog](https://github.com/startbootstrap/startbootstrap-clean-blog) for the client side.

__The project is in its early stages, expect errors and missing features.__

# Installation 

* Clone the repository using `git clone`
* Create an `.env` file by copying `.env.example`
* Run `composer install`
* Generate an `APP_KEY` by running `php artisan key:generate`
* Link the storage using `php artisan storage:link`
* Run the migrations using `php artisan migrate:fresh --seed`
* Install the frontend libraries using `npm install`
* Compile the frontend assets using `npm run dev`
