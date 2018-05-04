//自动化代码构建
var gulp = require('gulp');
//
var less = require('gulp-less'),
    sourcemaps = require('gulp-sourcemaps'),
    postcss = require('gulp-postcss'),
    autoprefixer = require('autoprefixer'),
    cssnano = require('cssnano');
    //gulpMultProcess = require('gulp-multi-process');

var livereload = require('gulp-livereload');
var browserSync = require('browser-sync').create();

var htmlPath = '../application/index/view/*/*.html';
var cssPath = '../public/static/css/style.css';

gulp.task('lessTask', function() {
  var processor = [
    autoprefixer,
    cssnano
  ];
  gulp.src('less/style.less')
    .pipe(sourcemaps.init())
    .pipe(less())
    .pipe(postcss(processor))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('../public/static/css'))
    .pipe(livereload());
});

gulp.task('server', function() {
  browserSync.init({
    proxy: "lab.local",  //指定代理url
    // notify: false, //刷新不弹出提示
  });
});

gulp.task('reload', function() {
  browserSync.reload(htmlPath);
});

gulp.task('auto', function() {
  gulp.watch(htmlPath, ['reload']);
  gulp.watch('less/components/*.less', ['lessTask']
  //   function() {
  //   gulpMultProcess(['lessTask'],function(){});
  // }
  );
  gulp.watch('less/style.less', ['lessTask']);
  gulp.watch(cssPath, ['reload']);
});

gulp.task('default', ['server', 'lessTask', 'auto']);