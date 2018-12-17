import chug from 'gulp-chug';
import gulp from 'gulp';
import yargs from 'yargs';

const { argv } = yargs
  .options({
    rootPath: {
      description: '<path> path to public assets directory',
      type: 'string',
      requiresArg: true,
      required: false,
    },
    nodeModulesPath: {
      description: '<path> path to node_modules directory',
      type: 'string',
      requiresArg: true,
      required: false,
    },
  });

const config = [
  '--rootPath',
  argv.rootPath || '../../public/assets',
  '--nodeModulesPath',
  argv.nodeModulesPath || '../../node_modules',
];

export const buildAdmin = function buildAdmin() {
  return gulp.src('assets/backend/gulpfile.babel.js', { read: false })
    .pipe(chug({ args: config, tasks: 'build' }));
};
buildAdmin.description = 'Build admin assets.';

export const watchAdmin = function watchAdmin() {
  return gulp.src('assets/backend/gulpfile.babel.js', { read: false })
    .pipe(chug({ args: config, tasks: 'watch' }));
};
watchAdmin.description = 'Watch admin asset sources and rebuild on changes.';

export const buildApp = function buildApp() {
  return gulp.src('assets/frontend/gulpfile.babel.js', { read: false })
    .pipe(chug({ args: config, tasks: 'build' }));
};
buildApp.description = 'Build app assets.';

export const watchApp = function watchApp() {
  return gulp.src('assets/frontend/gulpfile.babel.js', { read: false })
    .pipe(chug({ args: config, tasks: 'watch' }));
};
watchApp.description = 'Watch app asset sources and rebuild on changes.';

// export const build = gulp.parallel(buildAdmin, buildApp);
export const build = gulp.parallel(buildAdmin);
build.description = 'Build assets.';

gulp.task('admin', buildAdmin);
gulp.task('admin-watch', watchAdmin);
gulp.task('app', buildApp);
gulp.task('app-watch', watchApp);

export default build;
