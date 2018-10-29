<?php

namespace Jasonlbeggs\TailwindPreset;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Console\Presets\Preset;

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

        File::copyDirectory(__DIR__.'/stubs/views/default', resource_path('views'));
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

        file_put_contents(app_path('Http/Controllers/HomeController.php'), static::compileControllerStub());

        File::copyDirectory(__DIR__.'/stubs/views/auth', resource_path('views'));
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
     * Update the given package array.
     *
     * @param  array  $packages
     * @return array
     */
    protected static function updatePackageArray(array $packages)
    {
        return [
            'axios' => '^0.18',
            'babel-eslint' => '^10.0.1' ,
            'cross-env' => '^5.2',
            'eslint-config-prettier' => '^3.1.0' ,
            'eslint-plugin-prettier' => '^3.0.0' ,
            'eslint-plugin-vue' => '^4.7.1' ,
            'eslint' => '^5.8.0' ,
            'laravel-mix-purgecss' => '^2.2',
            'laravel-mix' => '^2.1',
            'prettier' => '^1.14.3',
            'tailwindcss' => '^0.6',
            'vue' => '^2.5',
        ];
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
        if (! file_exists(resource_path('css'))) {
            File::makeDirectory(resource_path('css'), 0755, true);
        }

        if (! file_exists(resource_path('js'))) {
            File::makeDirectory(resource_path('js'), 0755, true);
        }

        if (! file_exists(resource_path('js/components'))) {
            File::makeDirectory(resource_path('js/components'), 0755, true);
        }
    }

    /**
     * Install all JavaScript files.
     *
     * @return void
     */
    protected static function installScripts()
    {
        copy(__DIR__.'/stubs/tailwind.stub', base_path('tailwind.js'));
        copy(__DIR__.'/stubs/webpack.mix.stub', base_path('webpack.mix.js'));

        copy(__DIR__.'/stubs/js/app.stub', resource_path('js/app.js'));
        copy(__DIR__.'/stubs/js/bootstrap.stub', resource_path('js/bootstrap.js'));

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

        copy(__DIR__.'/stubs/css/app.stub', resource_path('css/app.css'));
    }

    protected static function installFormatters()
    {
        if (!file_exists(base_path('.php_cs'))) {
            copy(__DIR__ . '/stubs/.php_cs.stub', base_path('.php_cs'));
        }

        if (!file_exists(base_path('.eslintrc.js'))) {
            copy(__DIR__ . '/stubs/.eslintrc.js.stub', base_path('.eslintrc.js'));
        }
    }
}
