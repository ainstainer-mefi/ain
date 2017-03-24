default: dev

build:
	@echo "Building production bundle..."
	NODE_ENV="production" npm run build

dev:
	@echo "Starting dev web server..."
	@php ./bin/console server:run




