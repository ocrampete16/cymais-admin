.PHONY: up down dump-keycloak-db restore-keycloak-db

up:
	vendor/bin/sail up --detach

down:
	vendor/bin/sail down

dump-keycloak-db:
	docker-compose exec keycloak-mysql mysqldump --all-databases -uroot > keycloak-dump.sql

restore-keycloak-db:
	docker-compose exec --no-TTY keycloak-mysql mysql -uroot < keycloak-dump.sql
