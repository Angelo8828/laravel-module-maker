<?php

namespace Angelo8828\MakeModule\Generators;

use Illuminate\Console\Command;

class ControllerGenerator
{
    /**
     * Module Name
     *
     * @var string
     */
    public $moduleName;

    /**
     * Controller Namespace
     *
     * @var string
     */
    public $controllerNamespace = '';

    /**
     * Is Resource Routing Enabled
     *
     * @var string
     */
    public $isResourceRoutingEnabled = false;

    public function __construct()
    {
        $this->controllerNamespace = config('module_maker.controller_namespace');
        $this->isResourceRoutingEnabled = config('module_maker.is_resource_routing_enabled');
    }

    /**
     * Executes the generation of controllers
     *
     * @return mixed
     */
    public function generate($moduleName)
    {
        $moduleName = studly_case(str_singular($moduleName));

        if ($this->controllerNamespace != '') {
            $moduleName = $this->controllerNamespace . '\\' . $moduleName;
        }

        $controllerParameters['name'] = str_plural($moduleName) . 'Controller';

        if ($this->isResourceRoutingEnabled) {
            $controllerParameters['--resource'] = 'default';
        }

        $this->call('make:controller', $controllerParameters);
    }
}

?>
