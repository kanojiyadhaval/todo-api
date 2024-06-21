# Makefile

up:
	docker-compose up -d --build

down:
	docker-compose down

migrate:
	docker-compose exec app php bin/console doctrine:migrations:migrate --no-interaction

install:
	docker-compose exec app composer install

setup: up install migrate
