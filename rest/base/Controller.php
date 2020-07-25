<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/25
 * Time: 6:59 PM
 */
namespace rest\base;

use roach\extensions\EString;
use roach\rest\Response;

/**
 * Class Controller
 * @package rest\controllers
 * @datetime 2020/7/25 7:00 PM
 * @author roach
 * @email jhq0113@163.com
 */
class Controller extends \roach\rest\Controller
{
    /**
     * @param int    $httpCode
     * @param string $body
     * @param array  $context
     * @return array
     * @datetime 2020/7/25 7:40 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public function response($httpCode, $body = '', array $context = [])
    {
        return [
            'httpCode' => $httpCode,
            'body'     => EString::interpolate($body, $context)
        ];
    }

    /**
     * @param mixed $result
     * @return string
     * @datetime 2020/7/25 7:02 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public function after($result)
    {
        if(!isset($result['httpCode'])) {
            $result['httpCode'] = Response::HTTP_OK;
        }

        if(is_array($result['body'])) {
            $result['body'] = json_encode($result['body'], JSON_UNESCAPED_UNICODE);
        }

        return $result;
    }
}