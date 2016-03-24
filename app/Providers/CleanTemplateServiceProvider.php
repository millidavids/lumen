<?php

namespace App\Providers;

use App\Console\Commands\CleanTemplate;
use Illuminate\Support\ServiceProvider;
use App\Console\Commands\MyCommand;

class CleanTemplateServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('command.clean.template', function()
        {
            return new CleanTemplate();
        });

        $this->commands(
            'command.clean.template'
        );
    }
}