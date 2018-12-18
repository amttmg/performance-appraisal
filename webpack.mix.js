let mix = require('laravel-mix');

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
mix.webpackConfig({
  resolve: {
    modules: [
      path.resolve(__dirname, "resources/assets/js/src"), "node_modules"
    ]
  }
});
mix.js('resources/assets/js/src/main.js', 'public/js').js('resources/assets/js/src/page.js', 'public/js');