APP_NAME=benchmark_app

.PHONY: help

help:
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

build: ## Build the image
	-@docker build -t $(APP_NAME) .
	-@docker run -it -v `pwd`/app:/app $(APP_NAME) chmod +x bin/console.php

benchmark: ## Run application for given data
	-@docker run -it -v `pwd`/app:/app $(APP_NAME) bin/console.php app:run 2>/dev/null; true

unit-tests: ## Run unit tests
	-@docker run -it -v `pwd`/app:/app $(APP_NAME) phpunit --testdox --coverage-html /app/coverage tests/ 2>/dev/null; true
