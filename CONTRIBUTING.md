# Running locally

1. GIT clone this repo
2. Setup local environment vars by running `cp .env.example .env` (already works with docker-compose)
3. Start the Docker VM by running `docker-machine start default` 
4. Boot the application container "stack" using Docker Compose by running `docker-compose up -d` (`-d` runs containers in the background)

> If you'd like to see the log output you can attach to consolidated logs with `docker-compose logs` (`ctrl + c` to exit)

5. Install composer dependencies by running `docker run -i -v $(pwd):/var/www/html realpage/builder:composer-1 composer install --prefer-dist`

> After composer dependencies are installed for the first time, you can use [builder commands](https://github.com/realpage/builder#usage) as shortcuts.

6. Run `docker exec -it $(docker ps -f name=fpm -q) php artisan migrate --seed` (or [use the shortcut](https://github.com/realpage/lumen/tree/readme-updates#is-there-a-shortcut-for-running-commands-within-specific-containers) ) to migrate and seed the database
7. Now visit the application at http://192.168.99.100 (the docker-machine's default IP)