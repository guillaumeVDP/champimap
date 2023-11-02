.PHONY: start migrations assets

start:
	docker compose up

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

migrations:
	docker compose exec php php bin/console doctrine:migration:migrate --no-interaction

assets:
	docker compose exec php yarn install
	docker compose exec php yarn build

composer_install:
	docker compose exec php composer install
