# URL Shortening Service

## Installation Guide
This guide will walk you through installing a Laravel URL Shortening app on your local development machine.

### Prerequisites
Before you begin ensure you have Docker installed:
 https://www.docker.com/products/docker-desktop/

### Installation Steps
Clone the project in your preferred terminal by running following command
```console
git clone git@github.com:a-smith-ind/url-shortening.git && cd url-shortening
```

Install PHP dependencies:

```console
cp .env.example .env 
```

This command downloads all the required PHP libraries specified in the project's composer.json file.


```console
docker run --rm --interactive --tty --volume $PWD:/app composer/composer install
```

Build project, run it and login into container
```console
./vendor/bin/sail build --no-cache 
```
```console
./vendor/bin/sail up -d && docker exec -it app bash
```

### Run tests
```console
./vendor/bin/phpunit tests
```

### Author
Luke S
