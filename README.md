# page-viewer

## How to run

```
λ cd /path/to/project/docker
λ mv .env.exaple .env
λ docker-compose exec php-fpm sh -c "composer install"
λ docker-compose exec mysql sh -c "mysql -u root -p example < /tmp/database.sql"
λ docker-compose up
```
