<?php


namespace Rekkles\AppStoreScrape;


class AppStore
{
    /**
     * Make new Instance
     * @param $name
     * @param array $config
     * @return mixed
     */
    public static function make($name, array $config)
    {
        $application = "\\Rekkles\\AppStoreScrape\\Lib\\$name";

        return new $application($config);
    }

    /**
     * Dynamically pass methods to the application.
     *
     * @param string $name
     * @param array $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }
}