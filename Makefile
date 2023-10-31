.PHONY: start

start:
	docker compose up

test:
	docker compose exec php vendor/bin/phpstan analyse src tests

watch:
	docker compose exec php yarn watch
