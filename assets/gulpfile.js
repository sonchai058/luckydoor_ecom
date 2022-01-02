var gulp          = require('gulp'),
    compass       = require('gulp-compass'),
    autoprefixer  = require('gulp-autoprefixer'),
    minifyCss     = require('gulp-minify-css'),
    notify        = require('gulp-notify'),
    // livereload    = require('gulp-livereload'),
    plumber       = require('gulp-plumber'),
    assetpaths    = require('gulp-assetpaths');

gulp.task('compass', function() {
  gulp.src('scss/**/*.scss')
    .pipe(plumber({
      errorHandler: function (error) {
        this.emit('end');
      }}))
   .pipe(compass({
      config_file: './config.rb',
      css: 'css',
      sass: 'scss',
      image: 'images',
      style: 'compressed'
    }))
   .on('error',function(err){})
   .pipe(minifyCss())
   .pipe(gulp.dest('css/'))
   // .pipe(livereload());
});

// gulp.task('php', function() {
//    return gulp.src(['**/*.php'])
//    .on('error',function(err){})
//    .pipe(livereload());
// });

gulp.task('watch', function() {
  // livereload.listen(35729);
   gulp.watch("scss/**/*.scss", ['compass']);
   // gulp.watch("**/*.php", ['php']);
});

gulp.task('default',['compass','watch']);
