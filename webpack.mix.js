let mix = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/build/js')
   .sass('resources/assets/sass/app.scss', 'public/build/css');

mix.webpackConfig({
    resolve: {
        symlinks: false,
        alias: {
            '@': path.resolve(__dirname, 'resources/assets/js/'),
        }
    },
});

if (mix.inProduction()) {
    mix.version();
}
