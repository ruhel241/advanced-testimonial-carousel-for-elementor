<?php namespace Viocon;

/**
 * This class gives the ability to access non-static methods statically
 *
 * Class AliasFacade
 *
 * @package Viocon
 */
class AliasFacade {

    /**
     * @var Container
     */
    protected static $atcfeInstance;

    /**
     * @param $method
     * @param $args
     *
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        if(!static::$atcfeInstance) {
            static::$atcfeInstance = new Container();
        }

        return call_user_func_array(array(static::$atcfeInstance, $method), $args);
    }

    /**
     * @param Container $instance
     */
    public static function setVioconInstance(Container $instance)
    {
        static::$atcfeInstance = $instance;
    }

    /**
     * @return \Viocon\Container $instance
     */
    public static function getVioconInstance()
    {
        return static::$atcfeInstance;
    }
}