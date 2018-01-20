<?php

namespace Angelo8828\MakeModule\Generators;

use Artisan;

class ControllerGenerator
{
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

    /**
     * Is Controller Name Plural
     *
     * @var string
     */
    public $isControllerNamePlural = true;

    public function __construct()
    {
        $this->controllerNamespace = config('module_maker.controller_namespace');

        $this->isResourceRoutingEnabled = config('module_maker.is_resource_routing_enabled');

        $this->isControllerNamePlural = config('module_maker.is_controller_name_plural');
    }

    /**
     * Executes the generation of controllers
     *
     */
    public function generate($moduleName)
    {
        $controllerParameters['name'] = $this->processName($moduleName);

        if ($this->isResourceRoutingEnabled) {
            $controllerParameters['--resource'] = 'default';
        }

        Artisan::call('make:controller', $controllerParameters);
    }

    /**
     * Process controller's name with namespace
     *
     * @param  string $moduleName
     * @return string
     */
    public function processName($moduleName)
    {
        $controllerName = studly_case($moduleName);

        $controllerName = str_singular($controllerName);
        if ($this->isControllerNamePlural) {
            $controllerName = str_plural($controllerName);
        }

        if ($this->controllerNamespace != '') {
            $controllerName = $this->controllerNamespace . '\\' . $controllerName;
        }

        return $controllerName . 'Controller';
    }
}

?>
