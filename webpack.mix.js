const mix = require('laravel-mix');

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
    .sourceMaps()
    .sass('resources/sass/app.scss', 'public/css')
mix.styles([
    'resources/css/*'
], 'public/css/all.css');
