<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/23
 * Time: 4:48 PM
 */
namespace rest\base;

use roach\rest\Response;

/**
 * Class Module
 * @package console\modules\v1
 * @datetime 2020/7/23 4:48 PM
 * @author roach
 * @email jhq0113@163.com
 */
class Module extends \roach\rest\Module
{
    /**
     * @param mixed $result
     * @return mixed|void
     * @datetime 2020/7/25 7:04 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public function after($result)
    {
        Response::response($result['httpCode'], $result['body']);
    }
}