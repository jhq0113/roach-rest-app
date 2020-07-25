<?php
namespace roach\rest;

use roach\extensions\ECli;
use roach\rest\base\IRouter;

/**
 * Class Router
 * @package roach\rest
 * @datetime 2020/7/14 4:44 下午
 * @author   roach
 * @email    jhq0113@163.com
 */
class Router extends IRouter
{
    /**
     * @return void
     * @datetime 2020/7/18 7:52 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public function router()
    {
        if(ECli::cli()) {
            $params = ECli::params();
            if(isset($params[0])) {
                $uri = '/'.ltrim($params[0], '/');
            }
        }else {
            $uri = $_SERVER['REQUEST_URI'];
        }

        $paramPosition = strpos($uri, '?');
        if($paramPosition === false) {
            $uri = substr($uri, 1);
        }else {
            $uri = substr($uri, 1, $paramPosition - 1);
        }
        if(empty($uri)) {
            return;
        }

        $list = explode('/', $uri, 4);
        if(isset($list[2])) {
            $list = array_slice($list, 0, 3);
            $this->module     = $list[0];
            $this->controller = $list[1];
            $this->action     = $list[2];
        } elseif (isset($list[1])) {
            $this->controller = $list[0];
            $this->action     = $list[1];
        } else {
            $this->controller = $list[0];
        }

        $this->route = implode('/', $list);
    }
}