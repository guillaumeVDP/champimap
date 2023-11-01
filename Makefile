.PHONY: start

start:
	docker compose -f docker-compose.yml -f docker-compose.dev.yml up

test:
	docker compose exec php vendor/bin/phpstan analyse src tests

watch:
	docker compose exec php yarn watch

enter_web:
	docker compose exec -it web bash

enter_php:
	docker compose exec -it php bash

enter_db:
	docker compose exec -it db bash