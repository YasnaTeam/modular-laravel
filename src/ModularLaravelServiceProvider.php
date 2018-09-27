<?php

namespace Yasnateam\Modular;

use Illuminate\Support\ServiceProvider;

class ModularLaravelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerHelper();
    }


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * register helpers
     */
    protected function registerHelper()
    {
        require_once __DIR__ . DIRECTORY_SEPARATOR . "helpers.php";
    }
}
