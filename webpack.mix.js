const mix = require('laravel-mix');
require("dotenv").config()

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.disableNotifications();

mix.copyDirectory('resources/images', 'public/images');
mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require("tailwindcss"),
    ]);

mix.sass('resources/scss/style.scss', 'public/css');
mix.js('resources/js/user.js', 'public/js');
mix.js('resources/js/lesson.js', 'public/js');
mix.js('resources/js/studentsClass.js', 'public/js');
mix.js('resources/js/work.js', 'public/js');
mix.js('resources/js/message.js', 'public/js');
