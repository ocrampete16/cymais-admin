.PHONY: up down dump-keycloak-db

up:
	vendor/bin/sail up --detach

down:
	vendor/bin/sail down

dump-keycloak-db:
	docker-compose exec keycloak-mysql mysqldump --all-databases -uroot > keycloak-dump.sql
