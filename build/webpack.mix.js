let mix = require('laravel-mix');

mix.webpackConfig({
    externals: {
        jquery: "jQuery",
        bootstrap: true
    }
});

mix.setResourceRoot('./');
mix.setPublicPath('../');

mix
    .copy("node_modules/smartbanner.js/dist/smartbanner.min.css", "../css/smartbanner.css")
    .copy("node_modules/smartbanner.js/dist/smartbanner.min.js", "../js/smartbanner.js")
