var browserify   = require('browserify');
var browserSync = require('browser-sync');
var buffer       = require('vinyl-buffer');
var concat = require('gulp-concat');
var env = process.env.GULP_ENV;
var gulp = require('gulp');
var gulpif = require('gulp-if');
var livereload = require('gulp-livereload');
var merge = require('merge-stream');
var order = require('gulp-order');
var sass = require('gulp-sass');
var source       = require('vinyl-source-stream');
var sourcemaps = require('gulp-sourcemaps');
var uglify = require('gulp-uglify');
var uglifycss = require('gulp-uglifycss');

var argv = require('yargs').argv;
var watchify     = require('watchify');

var rootPath = argv.rootPath || '../';
var appRootPath = rootPath + 'frontend/compiled/';
var vendorPath = argv.vendorPath || '';
var nodeModulesPath = rootPath + 'frontend/node_modules/';

var paths = {
  app: {
    js: [
      nodeModulesPath + 'jquery/dist/jquery.min.js',
      nodeModulesPath + 'foundation-sites/dist/foundation.js',
      'js/**.js'
    ],
    sass: [
      nodeModulesPath + 'foundation-sites/scss',
      'scss/app.scss'
    ],
    css: [

    ],
    img: [

    ],
    font: [
      nodeModulesPath + 'font-awesome/fonts/**'
    ]
  }
};

var onError = function(err) {
  console.log(err.message);
  this.emit('end');
};

// bundling js with browserify and watchify
var b = watchify(browserify('./js/main', {
  cache: {},
  packageCache: {},
  fullPaths: true
}).transform("babelify", {presets: ["es2015", "react"]}));

gulp.task('bundle-app-js', function () {
  return b.bundle()
    .on('error', onError)
    .pipe(source('bundle.js'))
    .pipe(buffer())
    .pipe(concat('bundle.js'))
    .pipe(gulpif(env === 'prod', uglify()))
    .pipe(gulp.dest(appRootPath + 'js/'));
});

gulp.task('app-js', function () {
  return gulp.src(paths.app.js)
    .pipe(concat('app.js'))
    .pipe(gulpif(env === 'prod', uglify()))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(appRootPath + 'js/'))
    .pipe(browserSync.stream())
    ;
});

gulp.task('app-css', function() {
  gulp.src([nodeModulesPath+'semantic-ui-css/themes/**/*']).pipe(gulp.dest(appRootPath + 'css/themes/'));

  var cssStream = gulp.src(paths.app.css)
      .pipe(concat('css-files.css'))
    ;

  var sassStream = gulp.src(paths.app.sass)
      .pipe(sass())
      .pipe(concat('sass-files.scss'))
    ;

  return merge(cssStream, sassStream)
    .pipe(order(['css-files.css', 'sass-files.scss']))
    .pipe(concat('style.css'))
    .pipe(gulpif(env === 'prod', uglifycss()))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(appRootPath + 'css/'))
    .pipe(livereload())
    ;
});

gulp.task('app-img', function() {
  return gulp.src(paths.app.img)
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(appRootPath + 'img/'))
    ;
});

gulp.task('app-font', function() {
  return gulp.src(paths.app.font)
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(appRootPath + 'fonts/'))
    ;
});

gulp.task('app-watch', function() {
  livereload.listen();

  gulp.watch(paths.app.js, ['app-js']);
  gulp.watch('js/**', ['bundle-app-js']);
  gulp.watch(paths.app.sass, ['app-css']);
  gulp.watch(paths.app.css, ['app-css']);
  gulp.watch(paths.app.img, ['app-img']);
});

gulp.task('default', ['app-js', 'app-css', 'app-img', 'app-font']);
gulp.task('watch', ['default', 'app-watch']);
