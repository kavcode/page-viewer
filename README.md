# Page viewer test task

## How to run

```
λ cd /path/to/project
λ mv .env.exaple .env
λ docker-compose run php-fpm composer install
λ docker-compose up -d
```

### How to stop 

Go to the project directory if you aren't there
```
λ  docker-compose down
```

### How to run tests
```
λ docker-compose exec php-fpm vendor/bin/codecept run unit
```

### How to check code styling
```
λ docker-compose exec php-fpm  vendor/bin/phpcs
```

### How to run static analysis

```
λ docker-compose exec php-fpm vendor/bin/psalm
```

## Description

Please create a simple page viewer. Pages are plain text or HTML
documents that are stored at a directory page or in a database
(database schema included).

The coded application must search for pages by their name. The
output must contain correct HTML document with page title and
content. Please display execution time in milliseconds at the end
of the output.

## Specifications

All plain text documents must be converted to HTML using the
following rules:

1.  Convert all URLs and emails into valid HTML links.
2.  Convert all text lines followed one by one and surrounded with
    empty lines into an HTML paragraph.
3.  Convert all paragraphs that end with a line filled by - (dash)
    or = (equation) into HTML header of first level.
4.  Convert all paragraphs that start from two or more number signs
    into HTML headers of 2nd and other levels, depending on number of
    number signs.
5.  Convert all paragraphs that start from asterisk into unordered
    list item. A few such paragraphs must be converted into a single
    unordered list with several list items.

## Delivery

Please create web application with using pure PHP and MySQL
**without** using any framework or library. Application structure
must be made with using OOP and MVC pattern. Please do not use
global functions or global variables, use objects only.
