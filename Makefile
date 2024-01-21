# main
init: docker backend
docker: docker-build docker-up
backend: composer-install
frontend: npm-install
check: backend-phpunit backend-php-cs-fixer
be-updated: composer-be-updated-all npm-be-updated-all
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
backend-create-migrate:
	docker compose run --rm backend-php-cli composer phinx create -- --configuration etc/phinx.php --template vendor/robmorgan/phinx/src/Phinx/Migration/Migration.up_down.template.php.dist $(name)
backend-run-migrate:
	docker compose run --rm backend-php-cli composer phinx migrate -- --configuration etc/phinx.php
backend-rollback-migrate:
	docker compose run --rm backend-php-cli composer phinx rollback -- --configuration etc/phinx.php
# npm
npm-install:
	docker compose run --rm frontend-node-cli npm install
npm-list:
	docker compose run --rm frontend-node-cli npm list --depth=0
npm-be-updated-all:
	docker compose run --rm frontend-node-cli npm outdated --depth=99999