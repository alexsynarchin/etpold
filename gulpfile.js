const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

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
gulp.task("copyfiles-site",function () {
    gulp.src("vendor/bower_components/bootstrap/less/**")
        .pipe(gulp.dest("resources/assets/site/less/bootstrap"));
    gulp.src("vendor/bower_components/bootstrap-sass/assets/stylesheets/**")
        .pipe(gulp.dest("resources/assets/site/sass/bootstrap"));
    gulp.src("vendor/bower_components/jquery/dist/jquery.js")
        .pipe(gulp.dest("resources/assets/site/js/"));
    gulp.src("vendor/bower_components/bootstrap/dist/js/bootstrap.js")
        .pipe(gulp.dest("resources/assets/site/js/"));
    gulp.src("vendor/bower_components/components-font-awesome/scss/**")
        .pipe(gulp.dest("resources/assets/site/sass/font-awesome/"));
    gulp.src("vendor/bower_components/components-font-awesome/fonts/**")
        .pipe(gulp.dest("public/assets/site/fonts/font-awesome/"));
    gulp.src("vendor/bower_components/components-font-awesome/less/**")
        .pipe(gulp.dest("resources/assets/libs/less/font-awesome/"));
});

elixir(function (mix) {
    elixir.config.assetsPath = './resources/assets/site/';
    mix.less('styles.less','public/assets/site/css/style.css');
    /*mix.sass('main.scss','public/assets/site/css/style.css');*/
   /* mix.scripts([
        'jquery.js',
        'bootstrap.js',
        'app.js'
    ],
        "public/assets/site/js/app.js");*/
});

