var addsrc = require('gulp-add-src'),
    autoprefixer = require('gulp-autoprefixer'),
    concat = require('gulp-concat'),
    cssmin = require('gulp-cssmin'),
    gulp = require('gulp'),
    less = require('gulp-less'),
    plumber = require('gulp-plumber'),
    rimraf = require('gulp-rimraf'),
    uglify = require('gulp-uglify');

gulp.task('css', function () {
    return gulp.src('assets/less/app.less')
        .pipe(plumber())
        .pipe(less())
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(cssmin())
        .pipe(addsrc(['bower_components/font-awesome/css/font-awesome.min.css']))
        .pipe(concat('all.css'))
        .pipe(gulp.dest('www/css'));
});

gulp.task('clean', function () {
    return gulp.src('www/{cs,font,image,j}s/**/*')
        .pipe(rimraf());
});

gulp.task('build', ['css', 'fonts', 'images', 'js']);

gulp.task('fonts', function () {
    var src = [
        'bower_components/bootstrap/fonts/*.{eot,svg,ttf,woff,woff2}',
        'bower_components/font-awesome/fonts/*.{eot,otf,svg,ttf,woff,woff2}'
    ];
    return gulp.src(src)
        .pipe(gulp.dest('www/fonts'));
});

gulp.task('images', function () {
    return gulp.src('assets/images/*')
        .pipe(gulp.dest('www/images'));
});

gulp.task('js', function () {
    return gulp.src('assets/js/app.js')
        .pipe(plumber())
        .pipe(uglify())
        .pipe(addsrc.prepend([
            'bower_components/jquery/dist/jquery.min.js',
            'bower_components/bootstrap/dist/js/bootstrap.min.js'
        ]))
        .pipe(concat('all.js'))
        .pipe(gulp.dest('www/js'));
});

gulp.task('rebuild', ['clean'], function () {
    gulp.start('build')
});
