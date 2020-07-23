<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/23
 * Time: 3:00 PM
 */
use common\extensions\Container;

/**引入Composer
 * @var \Composer\Autoload\ClassLoader $loader
 */
$loader = require ROOT_PATH.'/vendor/autoload.php';

//将Composer的ClassLoader放入容器
Container::set('loader', $loader);
