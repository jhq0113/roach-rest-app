<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/25
 * Time: 7:00 PM
 */
namespace rest\modules\v1\controllers;

/**
 * Class Controller
 * @package rest\modules\v1\controllers
 * @datetime 2020/7/25 7:00 PM
 * @author roach
 * @email jhq0113@163.com
 */
class Controller extends \rest\base\Controller
{
    /**
     * @var array
     * @datetime 2020/7/24 9:18 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public $actionMethodMap = [
        'index'  => [
            'GET'
        ],
        'info'   => [
            'GET'
        ],
        'create' => [
            'POST'
        ],
        'update' => [
            'PUT'
        ],
        'delete' => [
            'DELETE'
        ]
    ];
}