<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/18
 * Time: 6:28 PM
 */
namespace roach\rest\base;

use roach\Roach;

/**
 * Class IRouter
 * @package roach\rest\base
 * @datetime 2020/7/18 6:28 PM
 * @author roach
 * @email jhq0113@163.com
 */
abstract class IRouter extends Roach
{
    /**
     * @var string
     * @datetime 2020/7/18 7:00 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public $route;

    /**
     * @var string
     * @datetime 2020/7/18 9:27 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public $module;

    /**
     * @var string
     * @datetime 2020/7/18 9:27 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public $controller;

    /**
     * @var string
     * @datetime 2020/7/18 9:27 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public $action;

    /**
     * @return mixed
     * @datetime 2020/7/18 7:02 PM
     * @author roach
     * @email jhq0113@163.com
     */
    abstract public function router();
}