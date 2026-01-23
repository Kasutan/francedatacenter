// Grab our gulp packages
var gulp  = require('gulp'),
    sass = require('gulp-sass')(require('sass')),
    autoprefixer = require('gulp-autoprefixer'),
    sourcemaps = require('gulp-sourcemaps');





// Compile Sass, Autoprefix and minify
gulp.task('styles', function() {
    
    return gulp.src('sass/*.scss')
        .pipe(sourcemaps.init()) // Start Sourcemaps
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(sourcemaps.write('.')) // Creates sourcemaps for minified styles
		.pipe(gulp.dest('./'));

});


// Watch files for changes (without Browser-Sync)
gulp.task('watch', function() {

  // Watch .scss files
  gulp.watch('sass/*/*.scss', gulp.series('styles'));



  // Watch js files
 // gulp.watch('.//js/*.js', ['site-js']);


}); 

