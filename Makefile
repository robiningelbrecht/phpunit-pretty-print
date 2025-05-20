compose=docker compose

dc:
	@${compose} -f docker-compose.yml $(cmd)

dcr:
	@make dc cmd="run --rm php-cli $(cmd)"

stop:
	@make dc cmd="stop"

up:
	@make dc cmd="up -d"

build-containers:
	@make dc cmd="up -d --build"

down:
	@make dc cmd="down"

composer:
	@make dcr cmd="composer $(arg)"

# Code quality tools.
phpunit:
	@make dcr cmd="vendor/bin/phpunit -d --enable-pretty-print -d --compact $(arg)"

phpunit-with-coverage-report:
	@make phpunit arg="--coverage-clover=clover.xml -d --min-coverage=min-coverage-rules.php"

phpstan:
	@make dcr cmd="vendor/bin/phpstan --memory-limit=1G $(arg)"

csfix:
	@make dcr cmd="vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php"

delete-snapshots:
	find . -name __snapshots__ -type d -prune -exec rm -rf {} \;