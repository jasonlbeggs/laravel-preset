<?php

namespace Jasonlbeggs\TailwindPreset;

use Illuminate\Foundation\Console\Presets\Preset;
use Illuminate\Support\Facades\File;

class Tailwind extends Preset
{
    /**
     * Setup basic assets.
     *
     * @return void
     */
    private static function setup()
    {
        static::ensureResourceDirectoriesExist();
        static::updatePackages();

        static::installScripts();
        static::installStyles();
        static::installFormatters();

        static::removeNodeModules();
    }

    /**
     * Install authentication files.
     *
     * @return void
     */
    public static function install()
    {
        static::setup();
        static::installRoutes();

        static::installViews([
            'auth/passwords/email.stub',
            'auth/passwords/reset.stub',
            'auth/login.stub',
            'auth/register.stub',
            'auth/verify.stub',
            'errors/404.stub',
            'errors/419.stub',
            'errors/500.stub',
            'errors/503.stub',
            'layouts/partials/_header.stub',
            'layouts/base.stub',
            'dashboard.stub',
        ]);

        File::copy(
            __DIR__.'/stubs/controllers/DashboardController.stub',
            app_path('Http/Controllers/DashboardController.php')
        );
    }

    /**
     * Update the given package array.
     *
     * @param array $packages
     *
     * @return array
     */
    protected static function updatePackageArray(array $packages)
    {
        return [
            '@fullhuman/postcss-purgecss' => '^1.2.0',
            'axios' => '^0.18',
            'babel-eslint' => '^10.0.1',
            'cross-env' => '^5.2',
            'eslint' => '^5.16.0',
            'eslint-config-prettier' => '^4.2.0',
            'eslint-plugin-prettier' => '^3.0.1',
            'eslint-plugin-vue' => '^5.2.2',
            'form-backend-validation' => '^2.3.6',
            'laravel-mix' => '^4.0',
            'portal-vue' => '^2.1.4',
            'postcss-import' => '^12.0.1',
            'tailwindcss' => '^1.0.0',
            'vue' => '^2.6',
            'vue-template-compiler' => '^2.6',
        ];
    }

    /**
     * Create view directories.
     *
     * @param array $directories
     *
     * @return void
     */
    protected static function makeViewDirectories($directories)
    {
        foreach ($directories as $directory) {
            if (! is_dir($directory = resource_path('views/'.$directory))) {
                File::makeDirectory($directory, 0755, true);
            }
        }
    }

    /**
     * Copy the view stubs over to the application and rename them.
     *
     * @param string $baseDirectory
     * @param array  $views
     *
     * @return void
     */
    protected static function installViews($views)
    {
        File::deleteDirectory(resource_path('views'));

        static::makeViewDirectories([
            'auth/passwords',
            'errors',
            'layouts/partials',
        ]);

        foreach ($views as $view) {
            File::copy(
                __DIR__.'/stubs/views/'.$view,
                resource_path('views/'.str_replace('stub', 'blade.php', $view))
            );
        }
    }

    /**
     * Install authentication routes if they are not present.
     *
     * @return void
     */
    protected static function installRoutes()
    {
        File::copy(
            __DIR__.'/stubs/routes/web.stub',
            base_path('routes/web.php')
        );
    }

    /**
     * Create any directories that do not exist.
     *
     * @return void
     */
    protected static function ensureResourceDirectoriesExist()
    {
        collect(['css', 'css/partials', 'js'])
            ->each(function ($dir) {
                if (! file_exists(resource_path($dir))) {
                    File::makeDirectory(resource_path($dir), 0755, true);
                }
            });
    }

    /**
     * Install all JavaScript files.
     *
     * @return void
     */
    protected static function installScripts()
    {
        File::delete(base_path('webpack.mix.js'));

        File::copy(__DIR__.'/stubs/tailwind.config.stub', base_path('tailwind.config.js'));
        File::copy(__DIR__.'/stubs/webpack.mix.stub', base_path('webpack.mix.js'));

        File::copy(__DIR__.'/stubs/js/app.stub', resource_path('js/app.js'));
        File::copy(__DIR__.'/stubs/js/bootstrap.stub', resource_path('js/bootstrap.js'));

        File::deleteDirectory(resource_path('js/components'));
    }

    /**
     * Install stylesheets.
     *
     * @return void
     */
    protected static function installStyles()
    {
        File::deleteDirectory(resource_path('sass'));

        File::copy(__DIR__.'/stubs/css/app.stub', resource_path('css/app.css'));
        File::copy(__DIR__.'/stubs/css/partials/buttons.stub', resource_path('css/partials/buttons.css'));
        File::copy(__DIR__.'/stubs/css/partials/forms.stub', resource_path('css/partials/forms.css'));
    }

    protected static function installFormatters()
    {
        if (! file_exists(base_path('.php_cs'))) {
            File::copy(__DIR__ . '/stubs/.php_cs.stub', base_path('.php_cs'));
        }

        if (! file_exists(base_path('.eslintrc.js'))) {
            File::copy(__DIR__ . '/stubs/.eslintrc.js.stub', base_path('.eslintrc.js'));
        }
    }
}
