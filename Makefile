.PHONY: start

start:
	docker compose -f docker-compose.yml -f docker-compose.dev.yml up

test:
	docker compose exec php vendor/bin/phpstan analyse src tests

watch:
	docker compose exec php yarn watch
