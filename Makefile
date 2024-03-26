# main
init: docker backend frontend
docker: docker-build docker-up
backend: backend-clear-var composer-install backend-run-migrate backend-load-fixtures
frontend: npm-install
check: backend-phplint test backend-php-cs-fixer backend-psalm
be-updated: composer-be-updated-all npm-be-updated-all
test: backend-phpunit backend-load-fixtures
test-coverage: backend-phpunit-coverage backend-load-fixtures
infection:backend-phpunit-coverage backend-infection backend-load-fixtures
install: composer-install npm-install
# ansible
ansible-ping:
	ansible all -i ansible/inventory -m ping
ansible-server-confuguration:
	ansible-playbook -i ansible/inventory ansible/server-configuration.yml
ansible-main:
	ansible-playbook -i ansible/inventory ansible/main.yml
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
backend-phpunit-unit:
	docker compose run --rm backend-php-cli composer phpunit -- --testsuite unit
backend-phpunit-authentication:
	docker compose run --rm backend-php-cli composer phpunit-authentication
backend-phpunit-http:
	docker compose run --rm backend-php-cli composer phpunit-http
backend-phpunit-oauth:
	docker compose run --rm backend-php-cli composer phpunit-oauth
backend-phpunit-configurations:
	docker compose run --rm backend-php-cli composer phpunit-configurations
backend-phpunit-functional:
	docker compose run --rm backend-php-cli composer phpunit-functional
backend-phpunit-coverage:
	docker compose run --rm backend-php-cli composer phpunit-coverage
backend-php-cs-fixer:
	docker compose run --rm backend-php-cli composer php-cs-fixer
backend-create-migrate:
	docker compose run --rm backend-php-cli composer phinx create -- --configuration etc/phinx.php --template vendor/robmorgan/phinx/src/Phinx/Migration/Migration.up_down.template.php.dist $(name)
backend-run-migrate:
	docker compose run --rm backend-php-cli composer phinx migrate -- --configuration etc/phinx.php
backend-rollback-migrate:
	docker compose run --rm backend-php-cli composer phinx rollback -- --configuration etc/phinx.php
backend-psalm:
	docker compose run --rm backend-php-cli composer psalm
backend-infection:
	docker compose run --rm backend-php-cli composer infection
backend-infection-http:
	docker compose run --rm backend-php-cli composer infection -- --filter=src/Http
backend-infection-oauth:
	docker compose run --rm backend-php-cli composer infection -- --filter=src/OAuth
backend-infection-authentication:
	docker compose run --rm backend-php-cli composer infection -- --filter=src/Authentication
backend-load-fixtures:
	docker compose run --rm backend-php-cli composer run app fixtures:load
backend-clear-var:
	docker compose run --rm backend-php-cli sh -c 'rm -rf var/cache/* var/log/*'
backend-phplint:
	docker compose run --rm backend-php-cli composer phplint
# npm
npm-install:
	docker compose run --rm frontend-node-cli npm install
npm-list:
	docker compose run --rm frontend-node-cli npm list --depth=0
npm-be-updated-all:
	docker compose run --rm frontend-node-cli npm outdated --depth=99999
# frontend
frontend-jest:
	docker compose run --rm frontend-node-cli npm run test
frontend-jest-coverage:
	docker compose run --rm frontend-node-cli npm run test:coverage