const mix = require('laravel-mix');
const path = require('path');

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

mix.ts('resources/js/app.ts', 'public/js')
    .vue(
        {
          version: 3,
            options: {
              compilerOptions: {
                isCustomElement: (tag) => ['loan-form-wrapper', 'own-loans', ''].includes(tag),
              },
            },
          }
    )
    .alias({
      '@': path.join(__dirname, 'resources/js')
  })
    .sourceMaps()
    .sass('resources/sass/app.scss', 'public/css')
    .webpackConfig({
      devServer: {
          host: "0.0.0.0"
      }
  })

mix.styles([
    'resources/css/*'
], 'public/css/all.css');
