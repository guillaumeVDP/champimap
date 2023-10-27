.PHONY: start

start:
	symfony serve:start --port=8888

db:
	docker-compose up

stan:
	vendor/bin/phpstan analyse src tests

watch:
	yarn watch
