<?php

namespace Angelo8828\MakeModule\Generators;

use Artisan;

class ControllerGenerator
{
    /**
     * Module Name
     *
     * @var string
     */
    protected $moduleName;

    /**
     * Controller Custom Template File
     *
     * @var string
     */
    public $controllerCustomTemplateFile = '';

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

        $this->controllerCustomTemplateFile = config('module_maker.controller_custom_template_file');

        $this->isResourceRoutingEnabled = config('module_maker.is_resource_routing_enabled');

        $this->isControllerNamePlural = config('module_maker.is_controller_name_plural');
    }

    /**
     * Executes the generation of controllers
     *
     */
    public function generate($moduleName)
    {
        if ($this->controllerCustomTemplateFile != '' && !file_exists(base_path($this->controllerCustomTemplateFile))) {
            return false;
        }

        $this->moduleName = $moduleName;

        if ($this->controllerCustomTemplateFile != '') {
            $this->customController();
        } else {
            $this->normalController();
        }

        return true;
    }

    public function normalController()
    {
        $controllerParameters['name'] = $this->processName();

        if ($this->isResourceRoutingEnabled) {
            $controllerParameters['--resource'] = 'default';
        }

        Artisan::call('make:controller', $controllerParameters);
    }

    public function customController()
    {
        $customControllerString = file_get_contents(base_path($this->controllerCustomTemplateFile));

        $customControllerString = str_replace('Template123', str_singular(studly_case($this->moduleName)), $customControllerString);

        $customControllerString = str_replace('Template123s', str_plural(studly_case($this->moduleName)), $customControllerString);

        $controllerFile = 'app/Http/Controllers/'. $this->processName() .'.php';

        if (!$routeFile = fopen(base_path($controllerFile), "a")) {
            return false;
        }

        if (!fwrite($routeFile, $customControllerString)) {
            return false;
        }

        fclose($routeFile);
    }

    /**
     * Process controller's name with namespace
     *
     * @param  string $moduleName
     * @return string
     */
    public function processName()
    {
        $controllerName = studly_case($this->moduleName);

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
