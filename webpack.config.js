var Encore = require('@symfony/webpack-encore');
var WebpackBuildNotifierPlugin = require('webpack-build-notifier');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .addEntry('app', './assets/js/main.js')
    .addEntry('back', './assets/js/back.js')
    .addStyleEntry('global', './assets/css/global.scss')
    .addStyleEntry('dashboard', './assets/css/back.scss')
    .enableSassLoader(function (sassOptions) {
    }, {
        resolveUrlLoader: false
    })
    .autoProvidejQuery()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning()
;

var config = Encore.getWebpackConfig();

config.watchOptions = {poll: true, ignored: /node_modules/};
config.plugins.push(new WebpackBuildNotifierPlugin({sound: false}));

module.exports = config;