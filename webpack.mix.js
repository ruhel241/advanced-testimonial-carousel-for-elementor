let mix = require('laravel-mix');
mix.setPublicPath('assets');

mix.sass(
        './sass/atc-testimonial.scss',
        './assets/css/atc-testimonial.css'
    )