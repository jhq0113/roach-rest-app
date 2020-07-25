# roach-rest示例应用

## 使用方式

```bash
composer create-project jhq0113/roach-rest-app yourpath ^1.0
```

<!-- TOC -->
# 目录

- [1.目录结构介绍](#目录结构介绍) 
- [2.部署](#部署)
- [3.rest接口示例应用](#rest接口示例应用)
- [4.添加模块](#添加模块)
- [5.路由](#路由)
     - [5.1项目默认路由规则如下](#项目默认路由规则如下)
     - [5.2自定义路由](#自定义路由)
- [6.Controller](#Controller)
     - [6.1REQUEST_METHOD控制](#REQUEST_METHOD控制)
     - [6.2控制器生命周期](#控制器生命周期)
- [7.应用生命周期](#应用生命周期)
- [8.console应用](#console应用)

<!-- /TOC -->

## 目录结构介绍

```text
- common              项目公用目录
  -- config           项目公共配置
  -- extensions       项目公共扩展类
  -- ErrorHandler.php 项目默认公共异常错误处理类

- console             控制台应用目录
  -- base             控制台应用基础类
  -- config           控制台应用配置目录
  -- controllers      控制器应用控制器
  -- roach            控制台应用入口文件，给予执行权限时在linux平台为可执行文件

- rest                rest应用目录
  -- base             rest应用基础类
  -- config           rest应用配置目录
  -- modules          rest应用模块目录
    -- v1             v1模块目录
      -- controllers  v1模块控制器目录
      -- Module.php   模块类文件，当创建模块是此文件是必须的
  -- web              rest应用项目web目录
    -- index.php      rest应用入口文件
- vendor              项目composer依赖目录
```

[回到目录](#目录)

## 部署

> `nginx`部署`server`示例

```nginx
server {
    listen 80;
    server_name roach.360tryst.com;
    root /yourpath/rest/web;
    index index.php;

    try_files $uri $uri/ @rewrite;
    
    location @rewrite {
         rewrite ^/(.*)$ /index.php?_url=/$1;
    }
    
    location ~ \.php {
            fastcgi_index  /index.php;
            fastcgi_pass   127.0.0.1:9000;
            include fastcgi_params;
            fastcgi_split_path_info       ^(.+\.php)(/.+)$;
            fastcgi_param PATH_INFO       $fastcgi_path_info;
            fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
    
    location ~* \.(gif|jpg|jpeg|bmp|png|ico|txt|js|css)$ {    
         expires  1h;
    }
    
    access_log /logs/roach.log main;
}
```

[回到目录](#目录)

## rest接口示例应用

> rest接口示例代码文件为`rest/modules/v1/controllers/ProductController.php`

> 在项目根目录有个`product-test.php`文件，里面编写了默认rest接口的测试调用，如果您使用的是`phpstorm`IDE的话，可以直接使用

```text
### 添加商品
POST http://roach.360tryst.com/v1/product/create
Content-Type: application/x-www-form-urlencoded

name=roach-rest-app

### 商品列表
GET http://roach.360tryst.com/v1/product/index

### 商品详情
GET http://roach.360tryst.com/v1/product/info?id=1

### 修改商品
PUT http://roach.360tryst.com/v1/product/update?id=2
Content-Type: application/json

{"name":"roach-rest-app"}

### 删除商品
DELETE http://roach.360tryst.com/v1/product/delete?id=2
```

[回到目录](#目录)

## 添加模块

> 添加自定义模块分为以下几步

* a.在`modules`目录添加模块目录，如:`v2`
* b.在`v2`目录中添加类文件`Module.php`，内容如下

```php
<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/25
 * Time: 7:06 PM
 */
namespace rest\modules\v2;

/**
 * Class Module
 * @package rest\modules\v2
 * @datetime 2020/7/25 7:07 PM
 * @author roach
 * @email jhq0113@163.com
 */
class Module extends \rest\base\Module
{
    /**
     * @var string
     * @datetime 2020/7/25 7:07 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public $id = 'v2';
}
```

* c.在`v2`目录中添加目录`controllers`
* d.在`controllers`目录添加模块基类`Controller.php`文件，内容如下

```php
<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/25
 * Time: 7:00 PM
 */
namespace rest\modules\v2\controllers;

/**
 * Class Controller
 * @package rest\modules\v2\controllers
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
```

* e.在`controllers`目录添加业务控制器，如:`ProductController.php`，使之继承刚刚创建的控制器，具体业务代码可以参考示例控制器

[回到目录](#目录)

## 路由

### 项目默认路由规则如下

|REQUEST_URI|解析规则|
|:----------|:------|
|/word1|word1解析为controller|
|/word1/word2|word1解析为controller，word2解析为action|
|/word1/word2/word3|word1解析为module，word2解析为controller，word3解析为action|
|/word1/word2/word3/word4?word5=word6|word1解析为module，word2解析为controller，word3解析为action，word4不会解析，word5为参数key，word6为参数值|

### 自定义路由

> 项目路由类为`roach\rest\Router`，如果系统路由不能满足您的需要，我们可以自己实现一个路由，步骤如下

* a.创建路由类`NewRouter.php`，使之继承`roach\rest\base\IRouter`，并实现相关逻辑
* b.更改配置

```text
'app' => [
        'class'  => 'roach\rest\Application',
        //应用名称
        'name'   => 'roach',
        //路由
        'router' => [
            'class' => '\NewRouter',
        ],
    ]
```

[回到目录](#目录)

## Controller

### REQUEST_METHOD控制

> 每个action的`REQUEST_METHOD`的控制是靠`Controller`中`actionMethodMap`属性控制的，如下

```php
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
        //indexAction仅支持GET方式
        'index'  => [  
            'GET'
        ],
        //infoAction支持GET和POST两种方式
        'info'   => [
            'GET', 'POST'
        ],
        //createAction仅支持POST方式
        'create' => [
            'POST'
        ],
        //updateAction仅支持PUT方式
        'update' => [
            'PUT'
        ],
        //deleteAction仅支持DELETE方式
        'delete' => [
            'DELETE'
        ],
        //...未配置支持所有请求方式
    ];
}
```

### 控制器生命周期

> 控制器有`before`和`after`两个钩子方法，以下是控制器执行流程

```text
before方法执行 -> action执行 -> after执行
```

> 注意：

* a.`before`方法返回`false`时，`action`不会再执行，只有当`before`方法返回`true`时`action`才会执行
* b.`action`方法执行完毕后的结果会传递给`after`方法，`after`方法可以对`action`执行的数据结果做统一后续处理

[回到目录](#目录)

## 应用生命周期

```text
module执行before方法 -> controller执行before方法 -> controller执行action -> controller执行after方法 -> module执行after方法
```

[回到目录](#目录)

## console应用

> console应用是一个控制台应用，位于`console`目录

> console应用默认不使用模块，也可以参考`rest`应用添加模块应用

> console应用路由规则与`rest`应用路由规则一致

> console应用如果由`cron`定时任务执行，注意标注输出和错误输出异常，默认不进行输出

```bash
./console/roach controller/action param1 param2 param3
./console/roach module/controller/action param1 param2 param3
```

> 可以通过`roach\extensions\ECli::params()`来获取参数

[回到目录](#目录)

