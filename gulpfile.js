// include the required packages.
var gulp = require('gulp');
var stylus = require('gulp-stylus');
var concat = require('gulp-concat-css');

// Render styles
gulp.task('styles', function () {
    return gulp.src('./app/Resources/styles/**/*.styl')
        .pipe(stylus())
        .pipe(concat('all.css'))
        .pipe(gulp.dest('./web/assets/css/build'));
});

gulp.task('default', ['styles']);
