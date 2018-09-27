<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Module Namespace
    |--------------------------------------------------------------------------
    | Override this to determine which directory/namespace will be used to house your modules.
    */
    "namespace" => "Modules",

    /*
    |--------------------------------------------------------------------------
    | JSON Location
    |--------------------------------------------------------------------------
    | Override this to specify the path to JSON runtime configuration file.
    | This should be normally in a place ignored by GIT systems. But feel free to change this behavior. 
    */
    "runtime_json_path" => storage_path("modular"),

];
