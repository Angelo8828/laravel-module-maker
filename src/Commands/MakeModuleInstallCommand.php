<?php

namespace Angelo8828\MakeModule\Commands;

use Illuminate\Console\Command;

class MakeModuleInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make-module:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Module Maker configuration file';

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
        $sourceConfigFile = realpath(__DIR__ . '/..').'/config/module_maker.php';

        $destinationConfigFile = base_path('config/module_maker.php');

        if (!copy($sourceConfigFile, $destinationConfigFile)) {
            echo "Error! Module maker configuration file has not been created. \n";
            return;
        }

        echo "Module maker configuration file created! \n";
    }
}
