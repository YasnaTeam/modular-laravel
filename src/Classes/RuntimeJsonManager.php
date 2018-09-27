<?php

namespace Yasnateam\Modular\Classes;


class RuntimeJsonManager
{
    /**
     * keep an array version of the JSON file
     *
     * @var array|null
     */
    protected static $array = null;



    /**
     * read a particular key from the JSON
     *
     * @param string $key
     *
     * @return array|string
     */
    public static function read($key = null)
    {
        static::createFileIfNotExist();

        if (!is_array(static::$array)) {
            static::$array = static::getArrayFromFile();
        }

        if (!$key) {
            return static::$array;
        }
        if (isset(static::$array[$key])) {
            static::$array[$key];
        }

        return null;
    }



    /**
     * set something in the static array and write the file
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public static function set(string $key, $value)
    {
        static::$array[$key] = $value;
        static::writeToFile();
    }



    /**
     * write the static array into the file
     *
     * @return void
     */
    protected static function writeToFile()
    {
        $file = fopen(static::getFilePath(), 'w', true);
        fwrite($file, json_encode(static::$array,JSON_PRETTY_PRINT));
        fclose($file);
    }



    /**
     * get array from the json file
     *
     * @return array
     */
    protected static function getArrayFromFile(): array
    {
        $json = file_get_contents(static::getFilePath());

        try {
            $array = json_decode($json, true);
        } catch (\Exception $e) {
            $array = null;
        }

        if(!is_array($array)) {
            static::createFile();
            return [];
        }

        return $array;
    }



    /**
     * create the json file if not exist
     *
     * @return void
     */
    protected static function createFileIfNotExist()
    {
        if (!static::exists()) {
            static::createFile();
            static::$array = static::getEmptyTemplate();
        }
    }



    /**
     * create a file with an empty template
     *
     * @return void
     */
    protected static function createFile()
    {
        static::makePath(static::getDirectoryPath());

        static::$array = static::getEmptyTemplate();
        static::writeToFile();
    }



    /**
     * make the required path
     *
     * @param $path
     *
     * @return bool
     */
    protected static function makePath($path)
    {
        if (@mkdir($path) or @file_exists($path)) {
            return true;
        }
        return (static::makePath(dirname($path)) and @mkdir($path));
    }



    /**
     * check whether the json file exists or not
     *
     * @return bool
     */
    protected static function exists(): bool
    {
        return file_exists(static::getFilePath());
    }



    /**
     * get the path to the directory of json file
     *
     * @return string
     */
    protected static function getDirectoryPath()
    {
        $config = config("modular.runtime_json_path");

        if (str_contains($config, base_path())) {
            return $config;
        }

        return base_path() . DIRECTORY_SEPARATOR . $config;
    }



    /**
     * get the path to the json file
     *
     * @return string
     */
    protected static function getFilePath()
    {
        return static::getDirectoryPath() . DIRECTORY_SEPARATOR . "runtime.json";
    }



    /**
     * get a template content for the runtime JSON file
     *
     * @return array
     */
    protected static function getEmptyTemplate()
    {
        return [
             "active_modules" => [],
        ];
    }

}
