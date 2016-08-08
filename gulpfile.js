var gulp 		= require('gulp'),
	sass 		= require('gulp-sass'),
    sourcemaps  = require('gulp-sourcemaps'),
    prefix      = require('gulp-autoprefixer'),
    rename      = require('gulp-rename'),
    csscomb     = require('gulp-csscomb'),
    rtlcss 		= require('gulp-rtlcss');

gulp.task('style.css', function() {
    return gulp.src('assets/scss/style.scss')
        // .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'compact'}).on('error', sass.logError))
        // .pipe(csscomb())
        // .pipe(prefix("last 1 version", "> 1%", "ie 8", "ie 7"))
        // .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('.'));
});

gulp.task('rtl.css', ['style.css'], function() {
	return gulp.src('style.css')
        .pipe(rtlcss())
        .pipe(rename('rtl.css'))
        .pipe(gulp.dest('.'));
});

gulp.task('styles', ['rtl.css'], function() {
	// silcence
});

gulp.task('watch', ['styles'], function() {
    gulp.watch(['assets/scss/**/*.scss', 'components/**/*.scss'], ['styles']);
});
