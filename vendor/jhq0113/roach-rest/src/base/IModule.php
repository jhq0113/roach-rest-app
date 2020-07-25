<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/18
 * Time: 6:30 PM
 */
namespace roach\rest\base;

use roach\Roach;

/**
 * Class IModule
 * @package roach\rest\base
 * @datetime 2020/7/18 6:30 PM
 * @author roach
 * @email jhq0113@163.com
 */
class IModule extends Roach
{
    /**
     * @var string
     * @datetime 2020/7/18 9:57 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public $controllerNamespace;

    /**
     * @var string
     * @datetime 2020/7/18 6:30 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public $id;

    /**
     * @var string
     * @datetime 2020/7/18 6:43 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public $controllerId;

    /**
     * @var string
     * @datetime 2020/7/18 6:43 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public $actionId;

    /**
     * @var string
     * @datetime 2020/7/18 6:31 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public $defaultControllerId = 'index';

    /**
     * @var string
     * @datetime 2020/7/18 6:31 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public $defaultActionId     = 'index';

    /**
     * @return bool
     * @datetime 2020/7/18 10:11 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public function before()
    {
        return true;
    }

    /**
     * @param mixed $result
     * @return mixed
     * @datetime 2020/7/18 10:10 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public function after($result)
    {
        return $result;
    }
}