# Quena Web

Demo: [https://quena.klament.pl](https://quena.klament.pl) (both login and password are "admin")

## What is it?
Quena is a self-hosted knowledge management tool. It is intended to store fairly short parts of information (entries) like in a dictionary. Entry content is saved as [Markdown](https://en.wikipedia.org/wiki/Markdown) so you can use lists, formatted code, links, pictures etc. The search box lets you look up entries by their names. It also exposes API: https://quena.klament.pl/api

## What stack does it use?
Nginx, PHP 7.2 with Symfony 4, SQLite database engine.

## How can I run it?
1. Install [docker](https://docs.docker.com/install/) and [docker-compose](https://docs.docker.com/compose/install/) on your server.
2. Adjust the `docker-compose.prod.yml` file and copy it to the server.
3. Run `docker-compose up -d`. Docker images containing the application will be downloaded from Docker Hub.
4. Run `docker-compose exec quena_php bash` to get inside the PHP container.
5. Run `bin/install` to create the database.
6. Done!

The `docker-compose.demo.yml` file is used to run [the demo service](https://quena.klament.pl). It uses [nginx-proxy](https://github.com/jwilder/nginx-proxy) which helps a lot with running multiple applications on one server and managing SSL certificates.

## Quena Console
For looking up entries you can also use [Quena Console](https://github.com/zelton/quena-console/), a CLI that uses the web API.
