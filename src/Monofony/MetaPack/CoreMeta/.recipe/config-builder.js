var upath = require('upath');
var path = require('path');
var Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}


var build = (name, assetPath, vendorUiPath) => {
  console.log(`${assetPath}js/controllers.json`)
  Encore
    // the project directory where compiled assets will be stored
    .setOutputPath(`public/assets/${name}`)
    // the public path used by the web server to access the previous directory
    .setPublicPath(`/assets/${name}`)
    .cleanupOutputBeforeBuild()
    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge(`${assetPath}/js/controllers.json`)
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    // uncomment to define the assets of the project
    .addEntry(`app_${name}`, `${assetPath}/js/app.js`)
    // uncomment if you use Sass/SCSS files
    .enableSassLoader()
    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()
    .autoProvidejQuery()
    .disableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .copyFiles({
      from: `${assetPath}/img`,
      to: 'img/[path][name].[ext]',
    }, {
      from: upath.joinSafe(vendorUiPath, 'Resources/private/img'),
      to: 'img/[path][name].[ext]',
    })
    .configureFilenames({
      js: 'js/[name].[fullhash:8].js',
      css: 'css/[name].[fullhash:8].css',
    })
    .configureFontRule({
      filename: 'font/[name].[fullhash:8].[ext]'
    })
    .configureImageRule({
      filename: 'img/[name].[fullhash:8].[ext]',
    });
  ;

  const config = Encore.getWebpackConfig();
  config.name = name;
  config.resolve.alias = {
    '~': path.resolve(__dirname, '../../'),
    'sylius/ui': vendorUiPath + '/Resources/private',
  };

  Encore.reset();

  return config;
};

module.exports = build;