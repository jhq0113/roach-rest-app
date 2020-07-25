<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/18
 * Time: 6:29 PM
 */
namespace roach\rest\base;

use roach\events\Event;
use roach\events\EventObject;
use roach\Roach;

/**
 * Class IApplication
 * @package roach\rest\base
 * @datetime 2020/7/18 6:29 PM
 * @author roach
 * @email jhq0113@163.com
 */
abstract class IApplication extends Roach
{
    use Event;

    //请求路由
    const EVENT_ROUTER_BEFORE   = 'router:before';
    const EVENT_ROUTER_AFTER    = 'router:after';

    //请求调度
    const EVENT_DISPATCH_BEFORE = 'dispatch:before';
    const EVENT_DISPATCH_AFTER  = 'dispatch:after';

    /**
     * @var string
     * @datetime 2020/7/18 6:33 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public $name;

    /**
     * @var string
     * @datetime 2020/7/18 9:34 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public $namespace = 'rest';

    /**
     * @var IRouter
     * @datetime 2020/7/18 6:25 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public $router;

    /**应用维护的时候使用，所有请求将有catchAll配置的function处理
     * @var callable
     * @example
     * 在配置文件的app节点中增加如下配置
     * 'app' => [
     *      'catchAll'  => function() {
     *          exit(json_encode(['code' => 500, 'msg' => '页面在维护，请晚点再来', 'data' => [] ], JSON_UNESCAPED_UNICODE));
     *      }
     * ],
     * @datetime 2020/7/23 5:03 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public $catchAll;

    /**
     * @throws \ReflectionException
     * @datetime 2020/7/18 10:37 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public function run()
    {
        //捕捉所有请求
        if(is_callable($this->catchAll)) {
            return call_user_func($this->catchAll);
        }

        $event = new EventObject([
            'sender' => $this,
            'data'   => $this->router
        ]);

        $this->trigger(self::EVENT_ROUTER_BEFORE, $event);
        $this->router->router();
        $this->trigger(self::EVENT_ROUTER_AFTER, $event);

        $this->trigger(self::EVENT_DISPATCH_BEFORE, $event);
        $this->dispatch();
        $this->trigger(self::EVENT_DISPATCH_AFTER, $event);
    }

    /**
     * @return mixed
     * @datetime 2020/7/18 10:37 PM
     * @author roach
     * @email jhq0113@163.com
     */
    abstract public function dispatch();
}