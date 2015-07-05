test:
	vendor/bin/phpunit

coverage:
	vendor/bin/phpunit --coverage-html=build/coverage

view-coverage:
	open build/coverage/index.html

clean:
	rm -rf build/*
