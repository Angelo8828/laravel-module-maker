<?php

namespace Angelo8828\MakeModule\Commands;

use Illuminate\Console\Command;
use Angelo8828\MakeModule\Libraries\OutputFormatter;
use Angelo8828\MakeModule\Generators\RouteGenerator;
use Angelo8828\MakeModule\Generators\ControllerGenerator;

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
        $this->outputFormatter = new OutputFormatter;

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

        echo $this->outputFormatter->wrapSuccessMessage("Module generation completed!");
    }

    /**
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

    /**
     * Generates the controller
     *
     * @return mixed
     */
    public function generateController()
    {
        $controller = new ControllerGenerator;

        $controller->generate($this->argument('name'));

        echo $this->outputFormatter->wrapSuccessMessage("Controller generated successfully.");
    }

    /**
     * Generate routes
     *
     * @return mixed
     */
    public function generateRoutes()
    {
        $route = new RouteGenerator;

        if (!$route->generate($this->argument('name'))) {
            echo $this->outputFormatter->wrapErrorMessage("Error! Routes has not been created. Please check if route file is existing or permission to write is enabled.");
            return;
        }

        echo $this->outputFormatter->wrapSuccessMessage("Routes generated successfully.");
    }
}
