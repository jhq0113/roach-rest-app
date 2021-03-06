<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/23
 * Time: 2:59 PM
 */
return [
    'app' => [
        //应用名称
        'name'      => 'roach-console',
        'namespace' => 'console',
    ],
    //组件
    'components' => [
        //通用异常处理
        'errorHandler' => [
            'class' => 'roach\exceptions\ErrorHandler',
            'handler' => 'common\ErrorHandler::handler',
            'calls' => [
                'run'
            ]
        ]
    ]
];