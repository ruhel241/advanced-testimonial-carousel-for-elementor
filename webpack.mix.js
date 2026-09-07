let mix = require('laravel-mix');

mix.setPublicPath('assets');
mix.setResourceRoot('../');

mix.copy('resources/admin/images', 'assets/images');

mix.sass(
    'resources/sass/atc-testimonial.scss',
    'css/atc-testimonial.css'
);

mix.sass(
    'resources/sass/atc-editor.scss',
    'css/atc-editor.css'
);

mix.sass(
    'resources/sass/atc-admin.scss',
    'css/atc-admin.css'
);

mix.js(
    'resources/admin/boot.js',
    'js/boot.js'
);

mix.js(
    'resources/admin/start.js',
    'js/start.js'
).vue({
    version: 2
});

mix.js(
    'resources/admin/atc-testimonial.js',
    'js/atc-testimonial.js'
);

mix.js(
    'resources/admin/atc-admin.js',
    'js/atc-admin.js'
);

module.exports = mix;
