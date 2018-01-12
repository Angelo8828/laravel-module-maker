<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Route File
    |--------------------------------------------------------------------------
    |
    | This value determines the route file that the Laravel Module Maker will
    | utilize. The auto-generated routes will be placed at the bottom of the
    | route file each time the command will be runned.
    |
    */

    'route_file' => env('MODULE_MAKE_ROUTE_FILE', 'routes/web.php'),

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
];
