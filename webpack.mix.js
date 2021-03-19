let mix = require('laravel-mix');
mix.setPublicPath('assets');

mix.sass('./resources/sass/atc-testimonial.scss', './assets/css/atc-testimonial.css');
mix.js('resources/js/atc-testimonial.js', 'assets/js/atc-testimonial.js');
