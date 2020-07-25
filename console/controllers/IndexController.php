<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/23
 * Time: 4:00 PM
 */
namespace console\controllers;

use console\base\Controller;
use roach\extensions\ECli;

/**
 * Class IndexController
 * @package console\controllers\IndexController
 * @datetime 2020/7/23 4:01 PM
 * @author roach
 * @email jhq0113@163.com
 */
class IndexController extends Controller
{
    /**
     * @return array
     * @datetime 2020/7/25 8:44 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public function indexAction()
    {
        $params = ECli::params();
        ECli::info(json_encode($params, JSON_UNESCAPED_UNICODE));
    }
}