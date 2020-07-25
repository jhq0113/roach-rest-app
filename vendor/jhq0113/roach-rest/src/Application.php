<?php
namespace roach\rest;

use roach\rest\base\IApplication;
use roach\extensions\EHtml;
use roach\rest\exceptions\NotFoundException;
use roach\Container;
use roach\rest\base\IModule;
use roach\rest\base\IController;

/**
 * Class Application
 * @package roach\rest
 * @datetime 2020/7/14 4:43 下午
 * @author   roach
 * @email    jhq0113@163.com
 */
class Application extends IApplication
{
    /**
     * @return bool|mixed
     * @throws NotFoundException
     * @throws \ReflectionException
     * @datetime 2020/7/18 10:36 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public function dispatch()
    {
        if(is_null($this->router->module)) {
            $moduleClass = 'roach\rest\Module';
            $namespace = $this->namespace;
        }else {
            $namespace = $this->namespace.'\\modules\\'.$this->router->module;
            $moduleClass = $namespace.'\\Module';
            if(!class_exists($moduleClass)) {
                throw new NotFoundException('class '.EHtml::encode($moduleClass).' not found');
            }
        }

        /**
         * @var IModule $module
         */
        $module = Container::insure([
            'class' => $moduleClass
        ]);

        //控制器命名空间
        if(is_null($module->controllerNamespace)) {
            $module->controllerNamespace = $namespace.'\\controllers';
        }

        //控制器id
        if(is_null($this->router->controller)) {
            $module->controllerId = $module->defaultControllerId;
        } else {
            $module->controllerId = $this->router->controller;
        }
        //操作id
        if(is_null($this->router->action)) {
            $module->actionId = $module->defaultActionId;
        } else {
            $module->actionId = $this->router->action;
        }

        $canRun = $module->before();
        if(!$canRun) {
            return false;
        }

        $controllerClass = $module->controllerNamespace.'\\'.ucfirst($module->controllerId).'Controller';
        if(!class_exists($controllerClass)) {
            throw new NotFoundException('class '.EHtml::encode($controllerClass).' not found');
        }

        /**
         * @var IController $controller
         */
        $controller = Container::insure([
            'class'    => $controllerClass,
            'moduleId' => $module->id,
            'id'       => $module->controllerId,
        ]);

        $action = $module->actionId.'Action';
        if(!method_exists($controller, $action)) {
            throw new NotFoundException('action '.EHtml::encode($action).' not found');
        }
        $controller->actionId = $module->actionId;

        if(isset($controller->actionMethodMap[ $controller->actionId ])) {
            if(!in_array($_SERVER['REQUEST_METHOD'], $controller->actionMethodMap[ $controller->actionId ])) {
                throw new NotFoundException('action '.EHtml::encode($action).' not found');
            }
        }

        $runAction = $controller->before();
        if(!$runAction) {
            return false;
        }

        $result = call_user_func([ $controller, $action]);
        $result = $controller->after($result);
        return $module->after($result);
    }
}