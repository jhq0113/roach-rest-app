<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/23
 * Time: 3:01 PM
 */
use roach\extensions\EEnvir;
use common\extensions\EArray;
use common\extensions\Container;

define('APP_PATH', dirname(__DIR__));
require APP_PATH.'/config/bootstrap.php';

//获取配置
$config = EArray::merge(
    require ROOT_PATH.'/common/config/config.php',
    require APP_PATH.'/config/'.EEnvir::envir().'.php'
);

//将配置放入容器
Container::set('config', $config);

//注册组件
Container::registerComponents();

//实例化
$app = Container::insure($config['app']);

//将app放入容器
Container::set('app', $app);
$app->run();