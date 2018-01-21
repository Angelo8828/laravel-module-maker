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

    public function __construct()
    {
        $this->routeFile = config('module_maker.route_file');

        $this->isResourceRoutingEnabled = config('module_maker.is_resource_routing_enabled');

        $this->routeLetterCaseNamingConvention = config('module_maker.route_letter_case_naming_convention');
    }

    /**
     * Executes the generation of routes
     *
     * @return mixed
     */
    public function generate($moduleName)
    {
        $this->moduleName = $moduleName;

        $this->processHeader();

        if ($this->isResourceRoutingEnabled) {

            $this->resourceRoutes();
            return;
        }

        $this->customRoutes();

        if (!$routeFile = fopen(base_path($this->routeFile), "a")) {
            return false;
        }

        if (!fwrite($routeFile, $this->routeString)) {
            return false;
        }

        fclose($routeFile);

        return true;
    }

    public function resourceRoutes()
    {
        $controller = new ControllerGenerator;

        $this->routeString .= "Route::resource('" .$this->processNameConvention($this->moduleName). "'," .$controller->processName($this->moduleName) . ") \n";
    }

    public function customRoutes()
    {
        //
    }

    public function processHeader()
    {
        $this->moduleName = studly_case($this->moduleName);

        $this->routeString = "\n" . '// Routes for ' . str_plural($this->splitCamelCase($this->moduleName)) . "\n";
    }

    public function processNameConvention($routeName)
    {
        if ($this->routeLetterCaseNamingConvention == 'snake') {
            return snake_case($routeName);
        }

        return str_slug($routeName);
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
