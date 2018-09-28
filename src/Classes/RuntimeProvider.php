<?php

namespace Yasnateam\Modular\Classes;


class RuntimeProvider
{
    /**
     * keep an array version of the JSON file
     *
     * @var array|null
     */
    protected $array = null;



    /**
     * RuntimeProvider constructor.
     */
    public function __construct()
    {
        $this->createFileIfNotExist();
    }



    /**
     * read a particular key from the JSON
     *
     * @param string $key
     *
     * @return array|string
     */
    public function read($key = null)
    {
        if (!is_array($this->array)) {
            $this->array = $this->getArrayFromFile();
        }

        if (!$key) {
            return $this->array;
        }
        if (isset($this->array[$key])) {
            return $this->array[$key];
        }

        return null;
    }



    /**
     * set something in the $this->array and write the file
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function set(string $key, $value)
    {
        $this->array[$key] = $value;
        $this->writeToFile();
    }



    /**
     * write the $this->array into the file
     *
     * @return void
     */
    protected function writeToFile()
    {
        $file = fopen($this->getFilePath(), 'w', true);
        fwrite($file, json_encode($this->array, JSON_PRETTY_PRINT));
        fclose($file);
    }



    /**
     * get array from the json file
     *
     * @return array
     */
    protected function getArrayFromFile(): array
    {
        $json = file_get_contents($this->getFilePath());

        try {
            $array = json_decode($json, true);
        } catch (\Exception $e) {
            $array = null;
        }

        if (!is_array($array)) {
            $this->createFile();
            return [];
        }

        return $array;
    }



    /**
     * create the json file if not exist
     *
     * @return void
     */
    protected function createFileIfNotExist()
    {
        if (!$this->fileExists()) {
            $this->createFile();
            $this->array = $this->getEmptyTemplate();
        }
    }



    /**
     * create a file with an empty template
     *
     * @return void
     */
    protected function createFile()
    {
        $this->makePath($this->getDirectoryPath());

        $this->array = $this->getEmptyTemplate();
        $this->writeToFile();
    }



    /**
     * make the required path
     *
     * @param $path
     *
     * @return bool
     */
    protected function makePath($path)
    {
        if (@mkdir($path) or @file_exists($path)) {
            return true;
        }
        return ($this->makePath(dirname($path)) and @mkdir($path));
    }



    /**
     * check whether the json file exists or not
     *
     * @return bool
     */
    protected function fileExists(): bool
    {
        return file_exists($this->getFilePath());
    }



    /**
     * get the path to the directory of json file
     *
     * @return string
     */
    protected function getDirectoryPath()
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
    protected function getFilePath()
    {
        return $this->getDirectoryPath() . DIRECTORY_SEPARATOR . "runtime.json";
    }



    /**
     * get a template content for the runtime JSON file
     *
     * @return array
     */
    protected function getEmptyTemplate()
    {
        return [
             "active_modules" => [],
        ];
    }

}
