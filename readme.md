## Tailwind CSS Laravel Front-end Preset

This is a Laravel front-end preset for Tailwind CSS/Vue.js. This preset will replace the default Bootstrap scaffolding, including the example Vue.js component. It will also compile the assets using Laravel Mix and PurgeCSS in order to generate the smallest files possible and add PHP CS Fixer and ESLint/Prettier configurations.

### Installation

> **Warning**: Installing this preset will **overwrite** your existing views and assets, and should only be installed on a fresh instance of Laravel. Please use with caution.

To install this preset, you must first require the composer dependency in your application. Laravel will automatically register the service provider for you.

```
composer require jasonlbeggs/tailwind-preset
```

Now, install the `tailwind` preset. The `tailwind` preset includes the authentication scaffolding normally generated when `php artisan make:auth` is executed.

```
php artisan preset tailwind
```

Install the NPM packages using your favorite package manager.

```
npm install // yarn
```

Now you can compile the assets using any of the Laravel build scripts (dev, prod, watch).

```
npm run production // yarn production
```

Ensure that your database is properly configured and migrated, and you're done! At this point, you may remove the composer dependency, as it is no longer needed.

```
composer remove jasonlbeggs/tailwind-preset
```
