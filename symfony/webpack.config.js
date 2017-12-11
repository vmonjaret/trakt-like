var Encore = require('@symfony/webpack-encore');
var WebpackBuildNotifierPlugin = require('webpack-build-notifier');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .addEntry('app', './assets/js/main.js')
    .addStyleEntry('global', './assets/css/global.scss')
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