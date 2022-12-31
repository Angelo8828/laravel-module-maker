<?php

namespace Angelo8828\MakeModule\Generators;

/**
 * Class for generating routes
 *
 * @author Angelo Joseph M. Salvador <angelo8828@gmail.com>
 */
class RouteGenerator
{
    /**
     * Controller Generator instance
     *
     * @var class
     */
    protected $controller;

    /**
     * Module Name
     *
     * @var string
     */
    protected $moduleName;

    /**
     * Route String Generated
     *
     * @var string
     */
    protected $routeString = '';

    /**
     * Application Route File
     *
     * @var string
     */
    protected $routeFile;

    /**
     * Route Custom Template File
     *
     * @var string
     */
    protected $routeCustomTemplateFile;

    /**
     * Route Letter Case Naming Convention
     *
     * @var string
     */
    protected $routeLetterCaseNamingConvention = 'slug';

    /**
     * Is Resource Routing Enabled?
     *
     * @var boolean
     */
    protected $isResourceRoutingEnabled = false;

    /**
     * Is Named Routing Enabled?
     *
     * @var boolean
     */
    protected $isNamedRoutingEnabled = true;

    /**
     * Class constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->controller = new ControllerGenerator;

        $this->routeFile = config('module_maker.route_file');

        $this->routeCustomTemplateFile = config('module_maker.route_custom_template_file');

        $this->routeLetterCaseNamingConvention = config('module_maker.route_letter_case_naming_convention');

        $this->isResourceRoutingEnabled = config('module_maker.is_resource_routing_enabled');

        $this->isNamedRoutingEnabled = config('module_maker.is_named_routing_enabled');
    }

    /**
     * Executes the generation of routes
     *
     * @return mixed
     */
    public function generate($moduleName)
    {
        if ($this->routeCustomTemplateFile != '' && !file_exists(base_path($this->routeCustomTemplateFile))) {
            return false;
        }

        $this->moduleName = $moduleName;

        $this->processHeader();

        if ($this->isResourceRoutingEnabled) {
            $this->resourceRoutes();
        } else {
            $this->customRoutes();
        }

        if (!$routeFile = fopen(base_path($this->routeFile), "a")) {
            return false;
        }

        if (!fwrite($routeFile, $this->routeString)) {
            return false;
        }

        fclose($routeFile);

        return true;
    }

    /**
     * Appends route header comment to the routeString
     *
     * @return void
     */
    public function processHeader()
    {
        $this->moduleName = studly_case($this->moduleName);

        $this->routeString = "\n\n" . '// Routes for ' . str_plural($this->splitCamelCase($this->moduleName)) . "\n";
    }

    /**
     * Appends resource routes to the routeString
     *
     * @return void
     */
    public function resourceRoutes()
    {
        $this->routeString .= "Route::resource('" .str_plural($this->processNameConvention($this->moduleName)). "', '" .$this->controller->processName($this->moduleName) . "'); \n";
    }

    /**
     * Appends custom routes to the routeString according to the configuration specified
     *
     * @return void
     */
    public function customRoutes()
    {
        $customRouteString = '';

        if ($this->routeCustomTemplateFile != '') {
            $customRouteString = file_get_contents(base_path($this->routeCustomTemplateFile));
        }

        if ($customRouteString == '') {
            $customRouteString = file_get_contents(realpath(__DIR__ . '/../..') . '/templates/routes.php');
        }

        if (!$this->isNamedRoutingEnabled) {
            $customRouteString = $this->removeNamedRoutes($customRouteString);
        }

        $customRouteString = $this->removePHPTags($customRouteString);

        $customRouteString = $this->replaceTemplateSingularRoutes($customRouteString);

        $customRouteString = $this->replaceTemplatePluralRoutes($customRouteString);

        $customRouteString = $this->replaceTemplateControllerNames($customRouteString);

        if ($this->routeLetterCaseNamingConvention == 'snake') {
            $customRouteString = $this->replaceToSnakeRoutes($customRouteString);
        }

        $this->routeString .= trim($customRouteString);
    }

    /**
     * Changes the parameter string according to the specified route convention
     *
     * @param  string $routeName
     * @return string
     */
    public function processNameConvention($routeName)
    {
        $routeName = $this->splitCamelCase($routeName);

        if ($this->routeLetterCaseNamingConvention == 'snake') {
            return snake_case($routeName);
        }

        return str_slug($routeName);
    }

    /**
     * Converts studly case strings to human readable case strings
     * https://stackoverflow.com/a/23028424/4584535
     *
     * @param  string $string
     * @return string
     */
    private function splitCamelCase($string)
    {
        $array = preg_split(
            '/(^[^A-Z]+|[A-Z][^A-Z]+)/',
            $string,
            -1,
            PREG_SPLIT_NO_EMPTY
            | PREG_SPLIT_DELIM_CAPTURE
        );

        return implode(' ', $array);
    }

    /**
     * Removed named routes
     *
     * @param  string $customRouteString
     * @return string
     */
    private function removeNamedRoutes($customRouteString)
    {
        return preg_replace('/->name([\s\S]*?)\x29/', '', $customRouteString);
    }

    /**
     * Remove PHP tags
     *
     * @param  string $customRouteString
     * @return string
     */
    private function removePHPTags($customRouteString)
    {
        $customRouteString = str_replace('<?php', '', $customRouteString);
        return str_replace('?>', '', $customRouteString);
    }

    /**
     * Replace templates for singular routes
     *
     * @param  string $customRouteString
     * @return string
     */
    private function replaceTemplateSingularRoutes($customRouteString)
    {
        return str_replace('template-123', str_singular($this->processNameConvention($this->moduleName)), $customRouteString);
    }

    /**
     * Replace templates for plural routes
     *
     * @param  string $customRouteString
     * @return string
     */
    private function replaceTemplatePluralRoutes($customRouteString)
    {
        return str_replace('template-123s', str_plural($this->processNameConvention($this->moduleName)), $customRouteString);
    }

    /**
     * Replace templates for controller names
     *
     * @param  string $customRouteString
     * @return string
     */
    private function replaceTemplateControllerNames($customRouteString)
    {
        return str_replace('Template123Controller', $this->controller->processName($this->moduleName), $customRouteString);
    }

    /**
     * Replace slug routes to snake routes
     *
     * @param  string $customRouteString
     * @return string
     */
    private function replaceToSnakeRoutes($customRouteString)
    {
        return preg_replace('/-(?=[^()]*\))/', '_', $customRouteString);
    }
}
