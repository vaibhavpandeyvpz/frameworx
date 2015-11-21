var gulp = require('gulp'),
    gulpAddSrc = require('gulp-add-src'),
    gulpAutoPrefixer = require('gulp-autoprefixer'),
    gulpConcat = require('gulp-concat'),
    gulpCssmin = require('gulp-cssmin'),
    gulpLess = require('gulp-less'),
    gulpPlumber = require('gulp-plumber'),
    gulpPreSrc = gulpAddSrc.prepend,
    gulpUglify = require('gulp-uglify');

gulp.task('css', function () {
    return gulp.src('./assets/less/app.less')
        .pipe(gulpPlumber())
        .pipe(gulpLess())
        .pipe(gulpAutoPrefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(gulpCssmin())
        .pipe(gulpAddSrc(['./vendor/bower/font-awesome/css/font-awesome.min.css']))
        .pipe(gulpConcat('app.css'))
        .pipe(gulp.dest('./www/css'));
});

gulp.task('fonts', function () {
    var src = [
        './vendor/bower/bootstrap/fonts/*.{eot,svg,ttf,woff,woff2}',
        './vendor/bower/font-awesome/fonts/*.{eot,otf,svg,ttf,woff,woff2}'
    ];
    return gulp.src(src)
        .pipe(gulp.dest('./www/fonts'));
});

gulp.task('images', function () {
    return gulp.src('./assets/images/*')
        .pipe(gulp.dest('./www/images'));
});

gulp.task('js', function () {
    return gulp.src('./assets/js/app.js')
        .pipe(gulpPlumber())
        .pipe(gulpUglify())
        .pipe(gulpPreSrc([
            './vendor/bower/jquery/dist/jquery.min.js',
            './vendor/bower/bootstrap/dist/js/bootstrap.min.js'
        ]))
        .pipe(gulpConcat('app.js'))
        .pipe(gulp.dest('./www/js'));
});

gulp.task('default', ['css', 'fonts', 'js']);
