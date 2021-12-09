var elixir      = require('laravel-elixir')
        gulp    = require('gulp'),
        htmlmin = require('gulp-htmlmin');


elixir.extend('compress', function() {
    new elixir.Task('compress', function() {
        return gulp.src('./storage/framework/views/*')
            .pipe(htmlmin({
                collapseWhitespace:    true,
                removeAttributeQuotes: true,
                removeComments:        true,
                minifyJS:              false,
            }).on('error', console.log))
            .pipe(gulp.dest('./storage/framework/views/'));
    })
    .watch('./storage/framework/views/*');
});

// // HTML Compress
// elixir(function(mix) {
//     mix.compress();
// });

elixir(function(mix) {
    mix.copy('resources/assets/fonts', 'public/build/fonts');
    mix.copy('resources/assets/images', 'public/build/images');
    mix.styles([
        // 'OpenSans.css',
        // 'Lato900.css',
        'style.css',
        'menu.css',
        '960.css',
        '700.css',
        'mobil.css',
        'font-awesome.css',
        'owl.carousel.css',
        'owl.theme.css',
        'owl.transitions.css',
    ]);
    mix.scripts([
        'jquery.lazy.js',
        'marketpaketi.js',
        'menu.js',
        'owl.carousel.js',
        'maskedInputV1.js',
        'url.js',
        'ready.js'
    ]);

    mix.version([
        "public/css/all.css",
        "public/js/all.js"
    ]);
});

// var gulp = require('gulp'),
//     uglify = require('gulp-uglify');
    
// gulp.task('default', function(){
//     gulp.src('resources/assets/js/ready.js')
//     .pipe(uglify().on('error', console.log))
//     .pipe(gulp.dest('resources/assets/sass'));
// });
    