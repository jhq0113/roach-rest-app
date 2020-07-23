<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/23
 * Time: 3:00 PM
 */
return [
    'app' => [
        'class'  => 'roach\rest\Application',
        //应用名称
        'name'   => 'roach',
        //路由
        'router' => [
            'class' => 'roach\rest\Router',
        ],
        //事件支持
        /*'calls' => [
            [
                'method' => 'on',
                'params' => [
                    //路由之前
                    'router:before',
                    function(\roach\events\EventObject $event) {
                        echo $event->name.PHP_EOL;
                    }
                ]
            ],
            [
                'method' => 'on',
                'params' => [
                    //路由之后
                    'router:after',
                    function(\roach\events\EventObject $event) {
                        echo $event->name.PHP_EOL;
                    }
                ]
            ],
        ]*/
    ]
];