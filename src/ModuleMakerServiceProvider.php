<?php

namespace Angelo8828\MakeModule;

use Illuminate\Support\ServiceProvider;

class ModuleMakerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            realpath(__DIR__ . '/..').'/config/module_maker.php' => config_path('module_maker.php'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeModuleCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
