<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/23
 * Time: 3:02 PM
 */
namespace rest\modules\v1\controllers;

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
    /**
     * @var array
     * @datetime 2020/7/24 9:18 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public $actionMethodMap = [
        'index' => [
            'GET'
        ],
        'add' => [
            'POST'
        ]
    ];

    /**
     * @return array
     * @datetime 2020/7/23 5:19 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public function indexAction()
    {
        return [
            'code' => 200,
            'msg'  => $this->id,
            'data' => (object)[]
        ];
    }

    public function addAction()
    {
        return [
            'id' => $this->actionId
        ];
    }

    public function after($result)
    {
        exit(json_encode($result, JSON_UNESCAPED_UNICODE));
    }
}