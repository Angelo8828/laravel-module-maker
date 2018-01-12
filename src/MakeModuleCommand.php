<?php

namespace Angelo8828\MakeModule;

use Illuminate\Console\Command;

class MakeModuleCommand
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
        echo "Hello World!";
    }
}
