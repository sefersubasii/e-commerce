const mix = require('laravel-mix');

/**
 * Backend Assets
 */
mix.js('resources/assets/dashboard/js/admin.js', 'public/dashboard/js')
      .sass('resources/assets/dashboard/sass/admin.scss', 'public/dashboard/css');

/**
 * Frontend Assets
 */
mix.js('resources/assets/js/app.js', 'public/js')
      .js('resources/assets/js/pay.js', 'public/js')
      .js('resources/assets/js/address.js', 'public/js')
      .js('resources/assets/js/loader.js', 'public/js')
      .sass('resources/assets/sass/app.scss', 'public/css');

mix.styles([
      'public/css/app.css',
      'resources/assets/css/style.css',
      'resources/assets/css/menu.css',
      'resources/assets/css/960.css',
      'resources/assets/css/700.css',
      'resources/assets/css/mobil.css',
      'resources/assets/css/font-awesome.css',
      'resources/assets/css/owl.carousel.css',
      'resources/assets/css/owl.theme.css',
      'resources/assets/css/owl.transitions.css',
], 'public/css/all.css');

mix.babel([
      'public/js/app.js',
      'resources/assets/js/jquery.lazy.js',
      'resources/assets/js/menu.js',
      'resources/assets/js/owl.carousel.js',
      'resources/assets/js/maskedInputV1.js',
      'resources/assets/js/url.js',
      'resources/assets/js/ready.js',
      'resources/assets/js/marketpaketi.js',
], 'public/js/all.js');

mix.copyDirectory('resources/assets/fonts', 'public/fonts');
mix.copyDirectory('resources/assets/images', 'public/images');
mix.copy('resources/assets/images/AjaxLoader.gif', 'public/css/AjaxLoader.gif');
mix.copy('resources/assets/images/grabbing.png', 'public/css/grabbing.png');

if(mix.inProduction()){
    mix.version();
}