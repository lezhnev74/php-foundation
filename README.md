## Installation
To deploy current application locally, you need to follow these steps:
- copy `.env.example` to `.env` and adjust its contents to match your environment
- pull in dependencies by running `composer install`

## Examples
I provided two ways to run this app via console and browser:
- two for console (green and red paths). Run in your console both:
    - `php tests/console_bad.php` - will output pretty error page
    - `php tests/console_good.php` - will output "OK"
- two for HTTP
    - navigate to project folder and run internal php server: `php -S localhost:8081 -t tests`
    - now open in your browser: `http://localhost:8081/http_bad.php` and `http://localhost:8081/http_good.php`

## Packages
This app uses a couple of packages I'd like to explain:
- `vlucas/phpdotenv` - this pacakge will automatically import all ENV variables from `.env` file and make them available within the app. 
- `samrap/gestalt` - a pacakge to load configuration values from PHP files (in case you need other formats it supports a bunch)
- `illuminate/support` - this package needs explanation. It comes from Laravel Framework and I pulled it in because I am so used to syntactic sugar it offers - functions like `env(...)` or `array_get(...)` are so useful taht I just had to pull this one in the app. It does have some classes and interfaces that I don't use, not a big issue at all.
- `php-di/php-di` - The dipendency injection container. There are many more, this one feels okay to me.
- `doctrine/cache` - This package is required in order to optimize previous pacakge, so it will cache internal data. The cache is in general very useful for other stuff as well.
- `filp/whoops` - The error handler and formatter library. Outputs pretty responses in JSON, HTML and console modes.
- `monolog/monolog` - This one is to log things to files. 

 