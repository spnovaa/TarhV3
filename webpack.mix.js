const mix = require('laravel-mix');
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin');
var webpack = require('webpack');

mix.extend('vuetify', new class {
    webpackConfig(config) {
        config.plugins.push(new VuetifyLoaderPlugin())
    }
});
module.exports.plugins = [
    //...
    new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)
    //...
];
mix.vuetify();
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').version()
    .sass('resources/sass/app.scss', 'public/css').version();
