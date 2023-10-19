.PHONY: start

start:
	symfony serve:start

db:
	docker-compose up

stan:
	vendor/bin/phpstan analyse src tests
