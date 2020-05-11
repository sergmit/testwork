PHP = docker-compose exec service-php
NODE = docker-compose run --rm node

start:
	docker-compose up -d

build:
	docker-compose up -d --build

stop:
	docker-compose down --remove-orphans

bash:
	docker-compose exec service-php bash

restart: stop start

rebuild: stop build

front_dev:
	$(NODE) npm run dev

front_watch:
	$(NODE) npm run watch-poll