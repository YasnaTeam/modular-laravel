<?php

namespace Yasnateam\Modular;

use Illuminate\Support\ServiceProvider;
use Yasnateam\Modular\Classes\RuntimeJsonManager;

class ModularLaravelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfigs();
        $this->registerHelper();
        $this->prepareRuntimeJson();
    }



    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }



    /**
     * register package configs
     *
     * @return void
     */
    protected function registerConfigs()
    {
        $path = __DIR__ . "/../config/config.php";

        $this->mergeConfigFrom($path, "modular");
        $this->publishes([
             $path => config_path("modules.php"),
        ], "config");
    }



    /**
     * register package helpers
     *
     * @return void
     */
    protected function registerHelper()
    {
        require_once __DIR__ . DIRECTORY_SEPARATOR . "helpers.php";
    }



    /**
     * prepare runtime JSON
     */
    protected function prepareRuntimeJson()
    {
        RuntimeJsonManager::read();
    }
}
