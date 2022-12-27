# selects proper compose executable
ifneq (, $(shell which docker-compose))
	compose=docker-compose
else
    compose=docker compose
endif

start:
	$(compose) up -d
	@if [ ! -f ./var/first_start ]; then										\
		$(compose) exec back composer install;									\
		$(compose) exec back php bin/console d:m:migrate --no-interaction;		\
		touch ./var/first_start;												\
	fi

cs-fixer-fix:
	$(compose) exec back ./vendor/bin/php-cs-fixer fix --diff;