const
    gulp = require('gulp'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    sass = require('gulp-sass'),
    csso = require('gulp-csso'),
    autoprefixer = require('gulp-autoprefixer'),
    plumber = require('gulp-plumber'),
    concat = require('gulp-concat');

gulp.task('css', () => {
    return gulp.src(['resources/assets/css/**/*.css', '!src/css/**/*.min.css'])
        .pipe(plumber())
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(csso())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('dist/css'));
});

gulp.task('js', function(){
    return gulp.src(['resources/assets/js/**/*.js', '!src/js/**/*.min.js'])
        .pipe(plumber())
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('dist/js'));
});

gulp.task('scss', function(){
    return gulp.src('resources/assets/scss/main.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(csso())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('dist/css'));
});

gulp.task('watch', function(){
    gulp.watch('resources/assets/js/**/*.js', ['js']);
    gulp.watch('resources/assets/scss/**/*.scss', ['scss']);
    gulp.watch('resources/assets/css/**/*.css', ['css']);
});

gulp.task('default', [
    'css',
    'js',
    'scss',
    'watch',
]);
