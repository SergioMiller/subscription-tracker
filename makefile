.PHONY: up
up: ## Start dev environment
		docker compose -f docker-compose.yml up

.PHONY: build
build:
		docker compose -f docker-compose.yml build

.PHONY: stop
stop:
		docker compose stop

.PHONY: composer-install
composer-install:
		docker compose exec app sh -lc 'composer install'

.PHONY: composer-update
composer-update:
		docker compose exec app sh -lc 'composer update'

.PHONY: composer-require
composer-require:
		docker compose exec app sh -lc 'composer require $(package)'

.PHONY: db-migrate
db-migrate:
		docker compose exec app sh -lc 'php artisan migrate'

.PHONY: db-seed
db-seed:
		docker compose exec app sh -lc 'php artisan db:seed'

.PHONY: optimize
optimize:
		docker compose exec app sh -lc 'php artisan optimize'

.PHONY: swagger
swagger:
		docker compose exec app sh -lc './vendor/bin/openapi ./app -o ./storage/app'

.PHONY: app
app:
		docker compose exec app sh

.PHONY: redis
redis:
		docker compose exec redis sh

.PHONY: node
node:
		docker compose exec node bash

.PHONY: php-cs-fixer
php-cs-fixer:
		docker compose exec app sh -lc 'php-cs-fixer fix app/ config/ routes/ database/ tests/ --config=/var/www/.php-cs-fixer.php --allow-risky=yes'


.PHONY: phpstan
phpstan:
		docker compose exec app sh -lc 'vendor/bin/phpstan analyse app config routes database tests'

.PHONY: test
test:
		docker compose exec app sh -lc 'php artisan test'

.PHONY: node-build
node-build:
		docker compose exec node sh -lc 'npm run build'
