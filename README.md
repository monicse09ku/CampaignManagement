## About CampaignManagement

A Laravel Project for managing advertising campaigns. 

## Used Technologies
- Laradock
- Laravel Version 8.75
- MySQL
- React
- Bootstrap
- Laravel Caching

## Installation Process
- git clone https://github.com/laradock/laradock.git
- git clone https://github.com/monicse09ku/CampaignManagement.git
- In the laradock `.env` file add `DB_HOST=mysql` at the top and set `APP_CODE_PATH_HOST=../CampaignManagement/`
- `docker-compose up -d nginx mysql phpmyadmin`
- `winpty docker-compose exec workspace bash`
- `cd CampaignManagement`
- `chown -R www-data:www-data storage/ public/ bootstrap/`
- `chmod -R 777 public/ storage/ bootstrap/`
- In the CampaignManagement `.env` file change database connection with following
````
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=default
DB_USERNAME=default
DB_PASSWORD=secret 
````
- `docker-compose up -d nginx mysql phpmyadmin`
- `winpty docker-compose exec workspace bash`
- `composer install`
- `php artisan key generate`
- `php artisan migrate`
- `php artisan db:seed`
- `composer require laravel/passport`
- `php artisan migrate`
- `php artisan passport:install`
- `php artisan serve` or virtual host in the browser

## Functionalities
- Login
- Registration
- Campaigns Listing with Campaign Images View inside a Bootstrap Carousel
- Campaign Create
- Campaign Edit
- Campaign Delete
- React Component of Campaigns List with Images View inside a Carousel Component
- Api Authentication
- Campaigns List Api
- Single Campaign Api
- Campaign Create Api
- Unit Testing of Campaigns and User
- Feature Testing of Campaigns and User
- Laravel Caching

## Checking
- To Authenticate, Register as a new user or login using the credentials in the UserSeeder
- The React Modules are loaded in the home and will be visible upon login, click on the image preview button to see the image viewer React Component
- To check CRUD functionality, click on Campaigns in the top navigation, Campaigns list with caching of 60 seconds will load
- Click on `Add New` to add new campaign
- In the actions, there are three buttons, Image Preview Button, Edit Button and Delete Button
- To check Unit Tests, run `php artisan test` in the terminal
- To check the api, find the postman collection in the root directory, import in postman, set environment variable `{{url}}` and run `Login` inside `Auth` folder, copy the `token` and set environment variable `{{token}}`, check the api inside `Campaigns` folder 
