var yargs = require('yargs');
var upath = require('upath');
var Encore = require('@symfony/webpack-encore');

const {argv} = yargs
    .options({
        vendorPath: {
            description: '<path> path to vendor directory',
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

const vendorPath = upath.normalizeSafe(argv.vendorPath || '.');
const vendorUiPath = vendorPath === '.' ? '../../vendor/sylius/ui-bundle' : upath.joinSafe(vendorPath, 'sylius/ui-bundle');
const nodeModulesPath = upath.normalizeSafe(argv.nodeModulesPath || '../../node_modules');

Encore
// the project directory where compiled assets will be stored
    .setOutputPath('public/assets/backend')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/assets/backend')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    // uncomment to define the assets of the project
    .addEntry('app', './assets/backend/js/app.js')
    // uncomment if you use Sass/SCSS files
    .enableSassLoader((options) => {
        options.data = '@import "~semantic-ui-css/semantic.min.css";';
    })
    .autoProvidejQuery()
    .configureBabel()
    .disableSingleRuntimeChunk()
    .copyFiles({
        from: './assets/backend/img',
        to: 'img/[path][name].[ext]',
    }, {
        from: upath.joinSafe(vendorUiPath, 'Resources/private/img'),
        to: 'img/[path][name].[ext]',
    })
    .configureFilenames({
             js: 'js/[name].[hash:8].js',
             css: 'css/[name].[hash:8].css',
             images: 'img/[name].[hash:8].[ext]',
             fonts: 'font/[name].[hash:8].[ext]'
    });
;

const backConfig = Encore.getWebpackConfig();
backConfig.name = "backend";

Encore.reset();
Encore
// the project directory where compiled assets will be stored
    .setOutputPath('public/assets/frontend')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/assets/frontend')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    // uncomment to define the assets of the project
    .addEntry('app', './assets/frontend/js/app.js')
    // uncomment if you use Sass/SCSS files
    .enableSassLoader((options) => {
        options.data = '@import "~lightbox2/dist/css/lightbox.min.css"; @import "~semantic-ui-css/semantic.min.css";';
    })
    .autoProvidejQuery()
    .configureBabel()
    .disableSingleRuntimeChunk()
    .copyFiles({
        from: './assets/backend/img',
        to: 'img/[path][name].[ext]',
    }, {
        from: upath.joinSafe(vendorUiPath, 'Resources/private/img'),
        to: 'img/[path][name].[ext]',
    })
    .configureFilenames({
        js: 'js/[name].[hash:8].js',
        css: 'css/[name].[hash:8].css',
        images: 'img/[name].[hash:8].[ext]',
        fonts: 'font/[name].[hash:8].[ext]'
    });
;

const frontConfig = Encore.getWebpackConfig();
frontConfig.name = "frontend";

module.exports = [backConfig, frontConfig];
