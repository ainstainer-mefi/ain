default: dev

build:
	@echo "Building production bundle..."
	ng build --target=production --environment=prod --deploy-url http://ain.test/client/

dev:
	@echo "Starting dev web server..."
	ng serve --proxy-config proxy.conf.json
