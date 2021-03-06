'use strict';
var gulp = require('gulp');
var sass = require('gulp-sass')(require('sass'));
var rename = require("gulp-rename"); 
var webp = require('gulp-webp');
var concat = require('gulp-concat');

// =============== PATHS

var paths = {
    style: {
        src: "src/yum/scss/style.scss",
        dest: "yum/app/templates/default/css",
    },
    print: {
        src: "src/yum/scss/print.scss",
        dest: "yum/app/templates/default/css",
    },
    images: {
        src: [
            "src/yum/images/**/*.png",
            "src/yum/images/**/*.jpg",
            "src/yum/images/**/*.svg",
            ],
        dest: "yum/app/templates/default/images",       
    },
    js: {
        src: [
            "src/eventre/js/jquery.js",
            "src/eventre/js/popper.min.js",
            "src/eventre/js/bootstrap.min.js",
            "src/yum/js/custom.js"
            ],
        dest: "yum/app/templates/default/js",
    },
    watch: ["src/eventre/**/*.scss", "src/yum/**/*.scss", "src/yum/images/**/*", "src/eventre/js/**/*.js","src/yum/js/**/*.js"]
};


// =============== TASKS

function style_compressed() {
    return gulp.src( paths.style.src)
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(rename("./style.min.css"))   
        .pipe(gulp.dest(paths.style.dest))                                          // save
} exports.css = style_compressed

function print() {
    return gulp.src( paths.print.src)
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(rename("./print.min.css"))   
        .pipe(gulp.dest(paths.print.dest))                                          // save
} exports.print = print

function style_uncompressed() {
    return gulp.src( paths.style.src)
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest(paths.style.dest))                                          // save
} exports.css_full = style_uncompressed

function images() {
    return gulp.src( paths.images.src)
        .pipe(webp())
        .pipe(gulp.dest(paths.images.dest))                                          // save
} exports.img = images

function scripts() {
    return gulp.src( paths.js.src)
        .pipe(concat('all.js'))
        .pipe(gulp.dest(paths.js.dest))                                          // save
} exports.js = scripts

// =============== DEFAULT & WATCH

function watcher(){
    gulp.watch(paths.watch, { delay: 1000 }, gulp.parallel(style_compressed, style_uncompressed, images, scripts, print)) // gulp.series/gulp.parallel
  } exports.watch = watcher

gulp.task('default', gulp.series(watcher));

//  in case of emergency break glass
//  set-ExecutionPolicy RemoteSigned -Scope CurrentUser 