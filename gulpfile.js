var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

// elixir(function(mix) {
//     mix.sass('app.scss');
// });
// for copy directory
elixir(function(mix) {
    // mix.copy('node_modules/events/', 'public/events/');
    // mix.copy('node_modules/socket.io/', 'public/socket.io/');
    mix.styles(['public/assets/materialize_0.97.4/css/materialize.min.css'
        ,'public/assets/plugins/sidr/css/jquery.sidr.light.css'
        ,'public/assets/css/media.css'
        ],'public/js/general.css');
});
