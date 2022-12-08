/**
 * Gulp file
 *
 * @author Takuto Yanagida
 * @version 2022-12-08
 */

const SRC_JS_RAW  = ['src/**/*.js', '!src/**/*.min.js'];
const SRC_JS_MIN  = ['src/**/*.min.js'];
const SRC_SASS    = ['src/**/*.scss'];
const SRC_CSS_RAW = ['src/**/*.css', '!src/**/*.min.css'];
const SRC_CSS_MIN = ['src/**/*.min.css'];
const SRC_PHP     = ['src/**/*.php'];
const DEST        = './dist';

import gulp from 'gulp';

import { makeJsTask } from './gulp/task-js.mjs';
import { makeCssTask } from './gulp/task-css.mjs';
import { makeSassTask } from './gulp/task-sass.mjs';
import { makeCopyTask } from './gulp/task-copy.mjs';

const js_raw  = makeJsTask(SRC_JS_RAW, DEST, 'src');
const js_min  = makeCopyTask(SRC_JS_MIN, DEST);
const js      = gulp.parallel(js_raw, js_min);
const css_raw = makeCssTask(SRC_CSS_RAW, DEST, 'src');
const css_min = makeCopyTask(SRC_CSS_MIN, DEST);
const css     = gulp.parallel(css_raw, css_min);
const sass    = makeSassTask(SRC_SASS, DEST);
const php     = makeCopyTask(SRC_PHP, DEST);

const watch = done => {
	gulp.watch(SRC_JS_RAW, gulp.series(js_raw));
	gulp.watch(SRC_JS_MIN, gulp.series(js_min));
	gulp.watch(SRC_SASS, gulp.series(sass));
	gulp.watch(SRC_CSS_RAW, gulp.series(css_raw));
	gulp.watch(SRC_CSS_MIN, gulp.series(css_min));
	gulp.watch(SRC_PHP, gulp.series(php));
	done();
};

export const build = gulp.parallel(js, sass, css, php);
export default gulp.series(build , watch);
