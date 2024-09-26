## RESTful API using Laravel 10 (including unit test)
This project has been built using laravel 10. This project also implements Repo-Service Pattern

## Installation

Install this project using PHP >8.2 and Composer >2

```bash
  git clone https://github.com/IlhamSetiaji/restful-api-laravel.git
  cd restful-api-laravel
  composer Install
```

To initiate the project after Installation
```bash
  cp .env.example.env
  {change the db credentials}
  php artisan key:generate
```

To run migration files and seeders
```bash
  php artisan migrate --seed
```
If you want to use cache, don't forget to change it on .env file
```bash
  by default, this project use file as cache
```

To run this project

```bash
php artisan serve
```
To run the unit test
```bash
php artisan test
```

All API documentation will be listed on Postman
https://drive.google.com/drive/folders/1o4u6gaK8eCIFoeCni1sqqmZsBiwHFoLf?usp=sharing
