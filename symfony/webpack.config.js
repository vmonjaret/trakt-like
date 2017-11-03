var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .addEntry('app', './assets/js/main.js')
    .addStyleEntry('global', './assets/css/global.scss')
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: false
    })
    .autoProvidejQuery()
    .enableSourceMaps(!Encore.isProduction())

// create hashed filenames (e.g. app.abc123.css)
// .enableVersioning()
;

var config = Encore.getWebpackConfig();
config.watchOptions = { poll: true, ignored: /node_modules/ };

module.exports = config;