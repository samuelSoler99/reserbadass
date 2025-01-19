PATH_LOCAL=~/core-dev/reserbadass
PHP_SERVER_NAME=php_server_reserbadass
WEB_SERVER_NAME=web_server_reserbadass
MONGO_SERVER_NAME=mongo_server_reserbadass
PATH_DOCKER=/var/www/html/reserbadass/

DOCKER_NETWORK_IP := $(shell docker network inspect bridge -f '{{range .IPAM.Config}}{{.Gateway}}{{end}}' 2>/dev/null)
export CURRENT_UID := $(shell id -u):$(shell id -g)

define execute_command
	@docker container exec -it -w ${2} ${1}  ${3}
endef

define check_host
	@if grep -Fx '$(DOCKER_NETWORK_IP) ${1}' /etc/hosts; then echo 'Ya existe ${1} en /etc/hosts'; else echo '$(DOCKER_NETWORK_IP) ${1}' | sudo tee -a /etc/hosts;	fi
endef

# Docker
run:
	docker compose start

stop:
	docker compose stop

status:
	docker compose ps

destroy:
	docker compose down --volumes --rmi local
	docker builder prune -f

install: hosts
	$(MAKE) env
	$(MAKE) destroy
	docker compose up -d
	$(MAKE) composer-install

logs:
	docker compose logs -f

ssh-php:
	docker container exec -it $(PHP_SERVER_NAME) sh

ssh-nginx:
	docker container exec -it $(WEB_SERVER_NAME) sh

ssh-mongo:
	docker container exec -it $(MYSQL_SERVER_NAME) sh

hosts:
	$(call check_host, reserbadass.test)

composer-install:
	$(call execute_command, $(PHP_SERVER_NAME), $(PATH_DOCKER), composer install)

composer-update:
	$(call execute_command, $(PHP_SERVER_NAME), $(PATH_DOCKER), composer update)

composer-cc:
	$(call execute_command, $(PHP_SERVER_NAME), $(PATH_DOCKER), composer clear-cache)

# FICHEROS DE CONFIGURACIÓN LOCAL
env:
	@cp ./.docker-local/resources/reserbadass.env.local $(PATH_LOCAL)/.env.local
	@cp ./.docker-local/resources/reserbadass.env.test $(PATH_LOCAL)/.env.test

# MIGRACIONES
migration-generate:
	$(call execute_command, $(PHP_SERVER_NAME), $(PATH_DOCKER), php bin/console doctrine:migrations:generate)

migration-apply:
	$(call execute_command, $(PHP_SERVER_NAME), $(PATH_DOCKER), php bin/console --no-interaction doctrine:migrations:migrate)

migration-ini:
	$(call execute_command, $(PHP_SERVER_NAME), $(PATH_DOCKER), php bin/console --no-interaction doctrine:migrations:migrate first)

migration-status:
	$(call execute_command, $(PHP_SERVER_NAME), $(PATH_DOCKER), php bin/console doctrine:migrations:status)

migration-apply-test:
	$(call execute_command, $(PHP_SERVER_NAME), $(PATH_DOCKER), php bin/console --no-interaction doctrine:migrations:migrate --env=test)

migration-ini-test:
	$(call execute_command, $(PHP_SERVER_NAME), $(PATH_DOCKER), php bin/console --no-interaction doctrine:migrations:migrate first --env=test)

migration-status-test:
	$(call execute_command, $(PHP_SERVER_NAME), $(PATH_DOCKER), php bin/console doctrine:migrations:status --env=test)

unit-tests:
	$(call execute_command, $(PHP_SERVER_NAME), $(PATH_DOCKER), vendor/bin/phpunit --testsuite Unit)

integration-tests:
	$(call execute_command, $(PHP_SERVER_NAME), $(PATH_DOCKER), vendor/bin/phpunit --testsuite Integration)
