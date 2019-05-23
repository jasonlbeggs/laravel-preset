const mix = require('laravel-mix');

mix
  .postCss('resources/css/app.css', 'public/css')
  .js('resources/js/app.js', 'public/js')
  .options({
    postCss: [require('postcss-import'), require('tailwindcss')],
  });

if (mix.inProduction()) {
  mix
    .options({
      postCss: [
        require('@fullhuman/postcss-purgecss')({
          content: ['resources/views/**/*.blade.php', 'resources/js/**/*.vue'],
          defaultExtractor: content => content.match(/[A-Za-z0-9-_:/]+/g) || [],
        }),
      ],
    })
    .version();
}
