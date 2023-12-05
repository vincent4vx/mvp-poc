node_modules:
	npm ci

npm: node_modules

css: npm
	npm run css

css-watch: npm
	npm run css-watch

webpack-watch: npm
	npm run webpack-watch

up:
	docker-compose down
	docker-compose up -d

build:
	docker-compose down
	docker-compose build

shell: up
	docker-compose run cmd

status:
	docker-compose exec php php public/workerman.php status

bench-workerman:
	@echo "Benchmarking Workerman"
	wrk -c 64 -t 8 -d 15s 'http://127.0.0.1:8401/workerman/search?autocomplete=0&query=foo'

bench-workerman-direct:
	@echo "Benchmarking Workerman"
	wrk -c 64 -t 8 -d 15s 'http://127.0.0.1:8402/workerman/search?autocomplete=0&query=foo'

bench-fpm:
	@echo "Benchmarking FPM + Nginx"
	wrk -c 64 -t 8 -d 15s 'http://127.0.0.1:8401/fpm/search?autocomplete=0&query=foo'

bench: bench-workerman bench-fpm
