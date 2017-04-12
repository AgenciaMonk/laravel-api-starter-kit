<p align="center"><a href="https://laravel.com" target="_blank"><img width="550"src="http://agmonk.com/logo-open.svg"></a></p>

## Laravel Starter API

[![Build Status][ico-travis]][link-travis]
[![StyleCI][icon-styleci]][link-styleci]

Laravel Starter API will provide you with the tools for making API's that everyone will love.

[Documentation here][link-docs]

##  
- **API written in** [Laravel 5.4](https://github.com/laravel/laravel/releases/tag/v5.4.16)
- **JSON Web Token** (https://github.com/tymondesigns/jwt-auth/tree/develop)
- **CORS Middleware** (https://github.com/barryvdh/laravel-cors)
- **Transformation layer for data output** (https://github.com/thephpleague/fractal)

## Up and Running

- Clone this repository `$ git clone git@github.com:AgenciaMonk/Laravel-Api-Starter-Kit.git`
- Create the env file `$ cp .env.example .env`
- Generate a **random string with 32 characters** for the **APP_KEY** variable on your **.env** file.

**Using PHP built-in server**

- Create the database file `$ touch database/database.sqlite`
- Install composer dependencies `$ composer install`
- Generate a JWT secret key `$ php artisan jwt:secret`
- Migrate the database and run the seeders `$ php artisan migrate --seed`
- Start the server `$ php -S localhost:8000 -t public`

**Using Docker**

- Start docker `$ docker-compose up -d`
- Uncomment the database variables at the **.env** file.
- Install composer dependencies `$ docker-compose run app composer install`
- Generate a JWT secret key `$ docker-compose run app php artisan jwt:secret`
- Migrate the database and run the seeders `$ docker-compose run app php artisan migrate --seed`

Visit [http://localhost:8000](http://localhost:8000)

## Contributing

- Fork it!
- Create your feature branch from master: `$ git checkout -b feature/my-new-feature`
- Write your code, comment your code, test your code
- Commit your changes `$ git commit -am 'Add some feature'`
- Push to the branch `$ git push origin feature/my-new-feature`
- Submit a pull request to master branch

## Testing

``` bash
$ composer test
```

## Credits

- [Lucas Macedo][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-travis]: https://img.shields.io/travis/AgenciaMonk/laravel-api-starter-kit/develop.svg?style=flat-square
[icon-styleci]: https://styleci.io/repos/87351167/shield?branch=develop

[link-travis]: https://travis-ci.org/AgenciaMonk/laravel-api-starter-kit
[link-styleci]: https://styleci.io/repos/87351167
[link-author]: https://github.com/lucassmacedo
[link-contributors]: ../../contributors
[link-docs]: ./docs/README.md
