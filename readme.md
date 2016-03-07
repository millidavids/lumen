## Lumen Service Base Template

This application serves as an API Service base template for developing with [Laravel Lumen](http://lumen.laravel.com).

The project comes pre-configured with a `docker-compose.yaml` that uses Nginx, PHP-FPM and PostgreSQL.  Additionally
the application's `.env` configuration is pre-configured to work with the Docker development environment.

## Development requirements

* [Docker Toolbox](https://www.docker.com/products/docker-toolbox)
* [GIT Version Control client](https://git-scm.com/)

## Steps to run or make changes to the application

1. GIT clone this repo
2. Change directories into the application's root
3. Copy `.env.example` to `.env`
4. Install composer dependencies (`composer install`) either from your local machine in the application root, or from the `fpm` container's cli.
  * access the `fpm` container's cli with: `docker exec -it $(docker ps -f name=fpm -q) bash`
5. Check the IP of the docker machine you are running:
  * `docker-machine ip default`
  * It is usually `192.168.99.100`
6. Boot the application container "stack" using Docker Compose
  * `docker-compose up -d`
  * If you'd like to see the log output you can attach to consolidated logs with `docker-compose logs` (`ctrl + c` to exit)
7. Now visit the application in your browser at the docker-machine's IP (i.e. `192.168.99.100`)
8. `docker-compose stop` to stop the application

**Change database credentials and set an application key before developing a new application from this base foundation**