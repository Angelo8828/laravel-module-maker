<?php

return [

	/*
    |--------------------------------------------------------------------------
    | Model Namespace
    |--------------------------------------------------------------------------
    |
    | This value determines the namespace where your models ARE / WILL BE FOUND.
    | Models can be only placed inside the "app" directory. Please leave it as empty
    | if your namespace will be the "App" itself
    |
    | Example usage:
    | If your model namespace will be "App\Models", the value will be "Models". If you
    | wish that your namespace will be "App", please do not change the default value.
    |
    */

    'model_namespace' => env('MODULE_MAKE_MODEL_NAMESPACE', ''),

    /*
    |--------------------------------------------------------------------------
    | Is Migration Enabled?
    |--------------------------------------------------------------------------
    |
    | This value determines if auto-generation of database migration will be enabled.
    | The auto-generated migrations will be placed inside the "database/migrations"
    | directory. True by default.
    |
    */

    'is_migration_enabled' => env('MODULE_MAKE_IS_MIGRATION_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Is Resource Routing Enabled?
    |--------------------------------------------------------------------------
    |
    | This value determines if Laravel resource routing is enabled. If enabled, controllers
    | with full resource routes will be auto-generated. Please see
    | https://laravel.com/docs/5.5/controllers#resource-controllers for documentation guide.
    | False by default.
    |
    */
    'is_resource_routing_enabled' => env('MODULE_MAKE_IS_RESOURCE_ROUTING_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Controller Namespace
    |--------------------------------------------------------------------------
    |
    | This value determines the namespace where your controllers ARE / WILL BE FOUND inside
    | the "app\Http\Controllers" directory. Please leave it as empty if your namespace will
    | be the "App\Http\Controllers" itself.
    |
    | Example usage:
    | If your controllers are found inside the "Users" directory and you wish that your
    | controller namespace will be "App\Http\Controllers\Users", the value will be "Users".
    | If the directory will be "Admin", the value will be "Admin".
    |
    */

    'controller_namespace' => env('MODULE_MAKE_CONTROLLER_NAMESPACE', ''),

    /*
    |--------------------------------------------------------------------------
    | Route Letter Case Naming Convention
    |--------------------------------------------------------------------------
    |
    | This value determines the route letter case naming convention that will be applied
    | and followed in the auto-generation of routes. Only two letter cases, "slug" and "snake"
    | are currently acceptable. The default case will be "slug".
    |
    */

    'route_letter_case_naming_convention' => env('MODULE_MAKE_ROUTE_LETTER_CASE_NAMING_CONVENTION', 'slug'),

    /*
    |--------------------------------------------------------------------------
    | Route File
    |--------------------------------------------------------------------------
    |
    | This value determines the route file that the Laravel Module Maker will
    | utilize. The auto-generated routes will be placed at the bottom of the
    | route file each time the command will be runned. The default value is the
    | location of the route file for Laravel 5.5
    |
    */

    'route_file' => env('MODULE_MAKE_ROUTE_FILE', 'routes/web.php'),
];
