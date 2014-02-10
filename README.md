Time Log
========

Application to keep track of productivity and provide logistics feedback to the user. Time Log is currently under development.


Authors
------

This application was developed with collaboration among the following students:

Victor Nguyen

Haily De La Cruz

Gopal Adhikari

Zuoming Shi

Michael Knatz

James Yoshida



Running
------

Launch a terminal in the project root directory for `timelog` and follow the given directions:

1. If this is a fresh clone you need to run `composer install` in the current directory, otherwise go to next step
2. Run `php artisan migrate`, this will make sure all pending migrations are committed to the database. Migrations are located in `app/database/migrations` directory
3. Run `php artisan db:seed`, this will run the `run` function in files `app/database/seed/*Seed.php` which will populate the database with some dummy data
4. Finally, run `php artisan serve` to start the server



Laravel Tutorial
----------------

Time Log is being developed using the beautiful **Laravel** framework. If you need help understanding the basics of developing web applications using Laravel then you should checkout the following tutorial:

http://net.tutsplus.com/tutorials/php/laravel-4-a-start-at-a-restful-api/
