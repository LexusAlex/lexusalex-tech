# main
init: docker backend
docker: docker-build docker-up
backend:
# docker
docker-build:
	docker compose build --pull
docker-up:
	docker compose up -d
docker-down:
	docker compose down --remove-orphans