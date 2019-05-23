<?php

namespace Jasonlbeggs\TailwindPreset;

use Illuminate\Foundation\Console\PresetCommand;
use Illuminate\Support\ServiceProvider;

class TailwindServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        PresetCommand::macro('tailwind', function ($command) {
            Tailwind::install();

            $this->installMessage($command);
        });
    }

    /**
     * Print message after successful installation.
     *
     * @param \Illuminate\Console\Command $command
     *
     * @return void
     */
    protected function installMessage($command)
    {
        $command->info('Tailwind scaffolding installed successfully.');
        $command->comment('Please run "npm install && npm run production" to compile your fresh scaffolding.');
    }
}
