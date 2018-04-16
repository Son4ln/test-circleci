const {mix} = require('laravel-mix')

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

mix
  // .autoload({
  //   jquery: ['window.jQuery', 'jQuery', '$'],
  // })
  // .extract(['jquery', 'bootstrap-sass'], 'public/js/vendor.js')
  // .disableNotifications()
  // .js('resources/assets/js/analyze.js', 'public/js')
  // .js('resources/assets/js/chat.js', 'public/js')
  // .js('resources/assets/js/custom.js', 'public/js')
   ///.js('resources/assets/js/room.js', 'public/js')
  // .js('resources/assets/js/prime_projects.js', 'public/js')
  // .js('resources/assets/js/prime_projects.js', 'public/js')
  // .js('resources/assets/js/analyze.js', 'public/js')
   .js('resources/assets/js/s3.uploader.js', 'public/js')
  .version()
