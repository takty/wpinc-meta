/**
 * Gulp file
 *
 * @author Takuto Yanagida
 * @version 2022-03-23
 */

/* eslint-disable no-undef */
'use strict';

const SRC_JS_RAW  = ['src/**/*.js', '!src/**/*.min.js'];
const SRC_JS_MIN  = ['src/**/*.min.js'];
const SRC_SASS    = ['src/**/*.scss'];
const SRC_CSS_RAW = ['src/**/*.css', '!src/**/*.min.css'];
const SRC_CSS_MIN = ['src/**/*.min.css'];
const SRC_PHP     = ['src/**/*.php'];
const SRC_PO      = ['src/languages/**/*.po'];
const SRC_JSON    = ['src/languages/**/*.json'];
const DEST        = './dist';

const gulp = require('gulp');

const { makeCopyTask }   = require('./task-copy');
const { makeCssTask }    = require('./task-css');
const { makeJsTask }     = require('./task-js');
const { makeLocaleTask } = require('./task-locale');
const { makeSassTask }   = require('./task-sass');


// -----------------------------------------------------------------------------


const js_raw  = makeJsTask(SRC_JS_RAW, DEST, 'src');
const js_min  = makeCopyTask(SRC_JS_MIN, DEST);
const js      = gulp.parallel(js_raw, js_min);
const css_raw = makeCssTask(SRC_CSS_RAW, DEST, 'src');
const css_min = makeCopyTask(SRC_CSS_MIN, DEST);
const css     = gulp.parallel(css_raw, css_min);
const sass    = makeSassTask(SRC_SASS, DEST);
const php     = makeCopyTask(SRC_PHP, DEST);
const po      = makeLocaleTask(SRC_PO, DEST, 'src');
const json    = makeCopyTask(SRC_JSON, DEST, 'src');

const watch = done => {
	gulp.watch(SRC_JS_RAW, gulp.series(js_raw));
	gulp.watch(SRC_JS_MIN, gulp.series(js_min));
	gulp.watch(SRC_SASS, gulp.series(sass));
	gulp.watch(SRC_CSS_RAW, gulp.series(css_raw));
	gulp.watch(SRC_CSS_MIN, gulp.series(css_min));
	gulp.watch(SRC_PHP, gulp.series(php));
	gulp.watch(SRC_PO, po);
	gulp.watch(SRC_JSON, json);
	done();
};

exports.build   = gulp.parallel(js, sass, css, php, po, json);
exports.default = gulp.series(exports.build , watch);
