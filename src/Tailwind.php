<?php

namespace Jasonlbeggs\TailwindPreset;

use Illuminate\Container\Container;
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
     * Install single welcome view.
     *
     * @return void
     */
    public static function install()
    {
        static::setup();

        static::installViews('default', [
            'welcome.stub',
        ]);
    }

    /**
     * Install authentication files.
     *
     * @return void
     */
    public static function installWithAuth()
    {
        static::setup();
        static::installAuthRoutes();

        static::makeViewDirectories([
            'auth/passwords',
            'errors',
            'layouts/partials',
        ]);

        static::installViews('auth', [
            'auth/passwords/email.stub',
            'auth/passwords/reset.stub',
            'auth/login.stub',
            'auth/register.stub',
            'auth/verify.stub',
            'welcome.stub',
            'errors/404.stub',
            'errors/500.stub',
            'errors/503.stub',
            'layouts/partials/_content.stub',
            'layouts/partials/_header.stub',
            'layouts/base.stub',
            'home.stub',
            'welcome.stub',
        ]);

        file_put_contents(app_path('Http/Controllers/HomeController.php'), static::compileControllerStub());
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
            'axios' => '^0.18',
            'cross-env' => '^5.2',
            'laravel-mix' => '^4.0',
            'laravel-mix-purgecss' => '^4.1',
            'tailwindcss' => '^0.7',
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
    protected static function installViews($baseDirectory, $views)
    {
        // All files published by this package use a ".stub" file extension. The
        // purpose of doing this is to prevent any of the template files from
        // being confused with the files actually published by this preset.

        foreach ($views as $view) {
            File::copy(
                __DIR__.'/stubs/views/'.$baseDirectory.'/'.$view,
                resource_path('views/'.str_replace('stub', 'blade.php', $view))
            );
        }
    }

    /**
     * Install authentication routes if they are not present.
     *
     * @return void
     */
    protected static function installAuthRoutes()
    {
        if (str_contains(file_get_contents(base_path('routes/web.php')), 'Auth::routes();')) {
            return;
        }

        file_put_contents(
            base_path('routes/web.php'),
            "\nAuth::routes();\n\nRoute::get('/home', 'HomeController@index')->name('home');\n",
            FILE_APPEND
        );
    }

    /**
     * Compile the HomeController class.
     *
     * @return void
     */
    protected static function compileControllerStub()
    {
        return str_replace(
            '{{namespace}}',
            Container::getInstance()->getNamespace(),
            file_get_contents(__DIR__.'/stubs/controllers/HomeController.stub')
        );
    }

    /**
     * Create any directories that do not exist.
     *
     * @return void
     */
    protected static function ensureResourceDirectoriesExist()
    {
        collect(['css', 'js', 'js/components'])
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
        File::copy(__DIR__.'/stubs/tailwind.stub', base_path('tailwind.js'));
        File::copy(__DIR__.'/stubs/webpack.mix.stub', base_path('webpack.mix.js'));

        File::copy(__DIR__.'/stubs/js/app.stub', resource_path('js/app.js'));
        File::copy(__DIR__.'/stubs/js/bootstrap.stub', resource_path('js/bootstrap.js'));

        File::deleteDirectory(resource_path('js/components/ExampleComponent.vue'));
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
