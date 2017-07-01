SASS = sass --no-cache

sass:
	${SASS} src/assets/scss/app.scss src/assets/css/site.css

es6:
	browserify src/assets/es6/main.js -t babelify -o src/assets/js/main.js