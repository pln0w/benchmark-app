APP_NAME=bldr_benchmark_app

.PHONY: help

help:
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

build: ## Build the image
	@echo 'Building Docker image'
	docker build -t $(APP_NAME) .

benchmark: ## Run application for given data
	@echo 'Running benchmark app'
	docker run -i -t --rm --name="$(APP_NAME)" $(APP_NAME) bin/console app:run-benchmark --url=$(url) --competitors-urls=$(competitors)

unit-tests: ## Run unit tests
	@echo 'Running unit tests'
	docker run -i -t --rm --name="$(APP_NAME)" $(APP_NAME) bin/phpunit -vvv --colors=always --debug --testsuite Unit
