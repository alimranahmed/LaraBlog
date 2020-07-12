let mix = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/build/js')
    .sass('resources/assets/sass/app.scss', 'public/build/css');


//Tailwind Frontend
const tailwindcss = require('tailwindcss')

mix.sass('resources/assets/sass/frontend.scss', 'public/build/css')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('tailwind.config.js')],
    })

//End of tailwind frontend


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
