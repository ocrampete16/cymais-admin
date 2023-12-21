.PHONY: up down

up:
	vendor/bin/sail up --detach

down:
	vendor/bin/sail down
