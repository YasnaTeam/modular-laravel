<?php

if (!function_exists("modules")) {
    /**
     * get a shortcut to run ModuleHelper static methods
     *
     * @return \Yasnateam\Modular\Classes\ModulesHelper
     */
    function modules()
    {
        return \Yasnateam\Modular\Classes\ModulesHelper::class;
    }
}
