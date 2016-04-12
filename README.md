## Lumen Starter Template [![Build Status](https://travis-ci.org/realpage/lumen.svg?branch=master)](https://travis-ci.org/realpage/lumen)

This [Laravel Lumen](https://lumen.laravel.com) starter template is intended to be forked and used for new projects.

> For details on how to contribute to this repo, please check out the [contributing guide](https://github.com/Realpage/lumen/blob/master/CONTRIBUTING.md).

### What's Included

 * Latest version of Lumen
 * Pre-configured `docker-compose.yml` that uses nginx, php-fpm and PostgreSQL
 * [Travis-CI](https://travis-ci.org) integration:
    * checks [psr-2 compliance](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) (with [phpcs](https://github.com/squizlabs/PHP_CodeSniffer))
    * runs [phpunit](https://phpunit.de/) tests within docker containers
    * pushes deploy-ready containers for `develop`, `staging`, `master` branches to [DockerHub](http://hub.docker.com)

### Requirements

* [Docker Toolbox](https://www.docker.com/products/docker-toolbox)
* [GIT Version Control client](https://git-scm.com/)

### Using This Repository

1. FORK this repo **(do not clone)**
2. Reference the [contributing guide](https://github.com/realpage/lumen/blob/master/CONTRIBUTING.md) for running this application locally
3. `docker exec -it $(docker ps -f name=fpm -q) php artisan clean:template` to strip out example migrations, seeds, tests, etc...

### FAQ

#### Is there a shortcut for running commands within specific containers?

Yes!  [Using an alias](http://askubuntu.com/a/17537/132639) below, you can run commands in containers with `dockerexc fpm php -v` instead of `docker exec -it $(docker ps -f name=fpm -q) php -v`.

```
alias dockerexc='function _docker_exec(){ service=$1; shift; docker exec -it $(docker-compose ps -q ${service}) "$@" };_docker_exec'
```

Travis Test, run 2