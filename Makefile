# main
init: docker backend
docker: docker-build docker-up
backend: composer-install
check: backend-phpunit backend-php-cs-fixer
# docker
docker-build:
	docker compose build --pull
docker-up:
	docker compose up -d
docker-down:
	docker compose down --remove-orphans
#composer
composer-install:
	docker compose run --rm backend-php-cli composer install
composer-be-updated-all:
	docker compose run --rm backend-php-cli composer show -l -o
# backend
backend-phpunit:
	docker compose run --rm backend-php-cli composer phpunit
backend-php-cs-fixer:
	docker compose run --rm backend-php-cli composer php-cs-fixer