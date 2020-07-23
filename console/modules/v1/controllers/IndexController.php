<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/23
 * Time: 3:02 PM
 */
namespace console\modules\v1\controllers;

use roach\rest\Controller;

/**
 * Class IndexController
 * @package www\modules\v1\controllers
 * @datetime 2020/7/23 3:02 PM
 * @author roach
 * @email jhq0113@163.com
 */
class IndexController extends Controller
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