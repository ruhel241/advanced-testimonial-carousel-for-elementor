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
    protected static $atcInstance;

    /**
     * @param $method
     * @param $args
     *
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        if(!static::$atcInstance) {
            static::$atcInstance = new Container();
        }

        return call_user_func_array(array(static::$atcInstance, $method), $args);
    }

    /**
     * @param Container $instance
     */
    public static function setVioconInstance(Container $instance)
    {
        static::$atcInstance = $instance;
    }

    /**
     * @return \Viocon\Container $instance
     */
    public static function getVioconInstance()
    {
        return static::$atcInstance;
    }
}