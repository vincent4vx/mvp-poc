node_modules:
	npm ci

npm: node_modules

css: npm
	npm run css

css-watch: npm
	npm run css-watch

webpack-watch: npm
	npm run webpack-watch
