## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. Run `docker-compose build --pull --no-cache` to build fresh images
3. Run `docker-compose up` (the logs will be displayed in the current shell)
4. Run `docker-compose down --remove-orphans` to stop the Docker containers.
## Features

## Request example
post https://localhost/author/create
body: {"name": "Test Name", "token": "123"}

post https://localhost/book/create
body: {"title": "test1|тест", "author": "Ivanov", "token": "BMvBP+F1VrbhGx0zpCIdnSpfLtoeFyN4MdYQdgv30RKAL+jE1gb/5llFJLaRcdANFmew9hiydw58LWXmrmZ0FA=="}

post https://localhost/ru/book/search
body: '{"title": "тест", "token": "BMvBP+F1VrbhGx0zpCIdnSpfLtoeFyN4MdYQdgv30RKAL+jE1gb/5llFJLaRcdANFmew9hiydw58LWXmrmZ0FA=="}'

* Production, development and CI ready
* Automatic HTTPS (in dev and in prod!)
* HTTP/2, HTTP/3 and [Preload](https://symfony.com/doc/current/web_link.html) support
* Built-in [Mercure](https://symfony.com/doc/current/mercure.html) hub
* [Vulcain](https://vulcain.rocks) support
* Just 2 services (PHP FPM and Caddy server)
* Super-readable configuration
