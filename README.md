# roach-rest示例应用

## 使用方式

```bash
composer create 
```

## 1.目录结构介绍

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

## 2.部署

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

## 3.`rest`接口示例应用

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

