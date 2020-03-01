DOT_FILE = .env

ifeq ("$(wildcard $(DOT_FILE))","")
	DOT_FILE = .env.dev
endif

# Docker
compose:
	docker network create app || true
	docker-compose down
	docker-compose up --build -d

exec:
	docker-compose exec php sh

# Linter
lint: psalm php-cs-fixer

psalm:
	docker-compose exec php ./vendor/bin/psalm --show-info=false

php-cs-fixer:
	docker-compose exec php ./vendor/bin/php-cs-fixer fix --using-cache=no --allow-risky yes

# Test
test:
	docker-compose exec php ./vendor/bin/phpunit