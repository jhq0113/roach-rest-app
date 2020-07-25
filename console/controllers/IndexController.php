<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/23
 * Time: 4:00 PM
 */
namespace console\controllers;

use roach\rest\base\IController;

/**
 * Class IndexController
 * @package console\controllers\IndexController
 * @datetime 2020/7/23 4:01 PM
 * @author roach
 * @email jhq0113@163.com
 */
class IndexController extends IController
{
    /**
     * @return array
     * @datetime 2020/7/25 8:44 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public function indexAction()
    {
        return [
            'mId'      => $this->moduleId,
            'id'       => $this->id,
            'actionId' => $this->actionId,
        ];
    }
}