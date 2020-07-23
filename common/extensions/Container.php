<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/23
 * Time: 3:47 PM
 */
namespace common\extensions;


/**
 * Class EComponents
 * @package common\extensions
 * @datetime 2020/7/23 3:48 PM
 * @author roach
 * @email jhq0113@163.com
 */
class Container extends \roach\Container
{
    /**
     * @throws \ReflectionException
     * @datetime 2020/7/23 3:52 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public static function registerComponents()
    {
        $config = self::get('config');

        if(isset($config['components'])) {
            foreach ($config['components'] as $component => $componentsConfig) {
                //定义了calls配置会直接实例化，未配置则为懒加载
                if(isset($componentsConfig['calls'])) {
                    Container::set($component, Container::insure($componentsConfig));
                } else {
                    Container::set($component, $componentsConfig);
                }
            }
        }
    }
}