<?php

namespace Angelo8828\MakeModule\Generators;

class RouteGenerator
{
    /**
     * Module Name
     *
     * @var string
     */
    protected $moduleName;

    /**
     * Application Route File
     *
     * @var string
     */
    protected $routeFile;

    /**
     * Is Resource Routing Enabled?
     *
     * @var boolean
     */
    protected $isResourceRoutingEnabled = false;

    /**
     * Route Letter Case Naming Convention
     *
     * @var string
     */
    protected $routeLetterCaseNamingConvention = 'slug';

    /**
     * Route String Generated
     *
     * @var string
     */
    protected $routeString = '';

    /**
     * Executes the generation of routes
     *
     * @return mixed
     */
    public function generate($moduleName)
    {
        $this->moduleName = $moduleName;

        $this->routeFile = config('module_maker.route_file');

        $this->isResourceRoutingEnabled = config('module_maker.is_resource_routing_enabled');

        $this->routeLetterCaseNamingConvention = config('module_maker.route_letter_case_naming_convention');

        $this->processRouteHeader();

        if ($this->isResourceRoutingEnabled) {

            $this->resourceRoutes();
            return;
        }

        $this->customRoutes();

        file_put_contents(base_path($this->routeFile), $this->routeString, FILE_APPEND | LOCK_EX);
    }

    public function resourceRoutes()
    {
        //
    }

    public function customRoutes()
    {
        //
    }

    public function processRouteHeader()
    {
        $this->routeString = "\n" . '// Routes for ' . str_plural($this->splitCamelCase($this->moduleName)) . "\n";
    }

    /**
     * Converts studly case strings to human readable case strings
     * https://stackoverflow.com/a/23028424/4584535
     * @param  string $string
     * @return string
     */
    private function splitCamelCase($string)
    {
        $array = preg_split(
            '/(^[^A-Z]+|[A-Z][^A-Z]+)/', $string, -1, PREG_SPLIT_NO_EMPTY
            | PREG_SPLIT_DELIM_CAPTURE
        );

        return implode(' ', $array);
    }
}

?>
