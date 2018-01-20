<?php

namespace Angelo8828\MakeModule\Commands;

use Illuminate\Console\Command;
use Angelo8828\MakeModule\Generators\RouteGenerator;

class MakeModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module
                           {name : The name of the module. Must be written in studly (upper camel) case if two or three more words}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->generateModelAndMigration();
        $this->generateController();
        $this->generateRoutes();

        echo "Module generation completed! \n";
    }

    /*
     * Generates the model and the migration
     *
     * @return mixed
     */
    public function generateModelAndMigration()
    {
        $modelNamespace = config('module_maker.model_namespace');

        $isMigrationEnabled = config('module_maker.is_migration_enabled');

        $moduleName = studly_case(str_singular($this->argument('name')));

        if ($modelNamespace != '') {
            $moduleName = $modelNamespace . '\\' . $moduleName;
        }

        $modelAndMigrationParameters['name'] = $moduleName;

        if ($isMigrationEnabled) {
            $modelAndMigrationParameters['--migration'] = 'default';
        }

        $this->call('make:model', $modelAndMigrationParameters);
    }

    public function generateController()
    {
        $controllerNamespace = config('module_maker.controller_namespace');

        $isResourceRoutingEnabled = config('module_maker.is_resource_routing_enabled');

        $moduleName = studly_case(str_singular($this->argument('name')));

        if ($controllerNamespace != '') {
            $moduleName = $controllerNamespace . '\\' . $moduleName;
        }

        $controllerParameters['name'] = str_plural($moduleName) . 'Controller';

        if ($isResourceRoutingEnabled) {
            $controllerParameters['--resource'] = 'default';
        }

        $this->call('make:controller', $controllerParameters);
    }

    public function generateRoutes()
    {
        $route = new RouteGenerator;

        $route->generate($this->argument('name'));

        echo "Routes generated successfully. \n";
    }
}
