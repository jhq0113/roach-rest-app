<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/23
 * Time: 4:34 PM
 */
namespace console\controllers;

use roach\rest\base\IController;

/**
 * Class CensusController
 * @package console\controllers
 * @datetime 2020/7/23 4:34 PM
 * @author roach
 * @email jhq0113@163.com
 */
class CensusController extends IController
{
    public function before()
    {
        return true;
    }

    public function indexAction()
    {
        return [
            'mId'      => $this->moduleId,
            'id'       => $this->id,
            'actionId' => $this->actionId,
        ];
    }

    public function after($result)
    {
        exit(json_encode($result).PHP_EOL);
    }


}