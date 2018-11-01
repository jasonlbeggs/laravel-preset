## Tailwind CSS Laravel Front-end Preset

[![Latest Stable Version](https://poser.pugx.org/jasonlbeggs/tailwind-preset/v/stable)](https://packagist.org/packages/jasonlbeggs/tailwind-preset)
[![Total Downloads](https://poser.pugx.org/jasonlbeggs/tailwind-preset/downloads)](https://packagist.org/packages/jasonlbeggs/tailwind-preset)
[![License](https://poser.pugx.org/jasonlbeggs/tailwind-preset/license)](https://packagist.org/packages/jasonlbeggs/tailwind-preset)

This is a Laravel front-end preset for Tailwind CSS/Vue.js. This preset will replace the default Bootstrap scaffolding, including the example Vue.js component. It will also compile the assets using Laravel Mix and PurgeCSS in order to generate the smallest files possible and add PHP CS Fixer and ESLint/Prettier configurations.

[View Screenshots](preview.md)

### Installation

> **Warning**: Installing this preset will **overwrite** your existing views and assets, and should only be installed on a fresh instance of Laravel. Please use with caution.

To install this preset, you must first require the composer dependency in your application. Laravel will automatically register the service provider for you.

```
composer require jasonlbeggs/tailwind-preset
```

Now, install either the `tailwind` or the `tailwind-auth` preset. The `tailwind-auth` preset includes the authentication scaffolding normally generated when `php artisan make:auth` is executed.

```
php artisan preset tailwind

// or

php artisan preset tailwind-auth
```

> **Note:** If you install the `tailwind-auth` preset on a version of Laravel that is older than 5.7, you may delete the `views/auth/verify.blade.php` file, as it will not be used.

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
