<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/24
 * Time: 8:08 PM
 */
namespace common;

use roach\extensions\ECli;
use roach\extensions\EEnvir;
use roach\extensions\EHtml;
use roach\extensions\EString;
use roach\extensions\IExtension;
use roach\rest\Response;

/**
 * Class ErrorHandler
 * @package common
 * @datetime 2020/7/24 8:08 PM
 * @author roach
 * @email jhq0113@163.com
 */
class ErrorHandler extends IExtension
{
    /**
     * @return string
     * @datetime 2020/7/24 8:14 PM
     * @author roach
     * @email jhq0113@163.com
     */
    protected function _getTemplate()
    {
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{title}</title>
</head>
<body>
<h1 style="text-align: center; color:#006400;">roach-rest</h1>
<div style="text-align: center;margin: 0 0;">
    <div>
        <h2 style="color: red;">{msg}</h2>
    </div>
    <div>
        <h3>{file}({line})</h3>
    </div>
    <div>
        {trace}
    </div>
</div>
</body>
</html>
HTML;
    }

    /**
     * @param \Throwable $exception
     * @datetime 2020/7/24 8:31 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public static function handler($exception)
    {
        if(ECli::cli()) {
            static::_handlerCli($exception);
        } else {
            static::_handlerWeb($exception);
        }
        exit();
    }

    /**
     * @param \Throwable $exception
     * @datetime 2020/7/24 8:36 PM
     * @author roach
     * @email jhq0113@163.com
     */
    protected static function _handlerCli($exception)
    {
        /**
         * @var \Throwable $exception
         */
        ECli::error($exception->getMessage());
        ECli::warn('文件：{file} {line}行', [
            'file' => $exception->getFile(),
            'line' => $exception->getLine()
        ]);
        ECli::warn($exception->getTraceAsString());
    }

    /**
     * @param \Throwable $exception
     * @datetime 2020/7/24 8:29 PM
     * @author roach
     * @email jhq0113@163.com
     */
    protected static function _handlerWeb($exception)
    {
        /**
         * @var \Throwable $exception
         */
        $msg  = EHtml::encode($exception->getMessage());
        $file = EHtml::encode($exception->getFile());

        $trace = '';
        $traceList = $exception->getTrace();
        foreach ($traceList as $item) {
            $trace .= "<h4>{$item['file']}({$item['line']}) {$item['class']}::{$item['function']}</h4>";
        }

        $html = EString::interpolate(static::_getTemplate(), [
            'title' => $msg,
            'msg'   => $msg,
            'file'  => $file,
            'line'  => $exception->getLine(),
            'trace' => $trace
        ]);

        if(EEnvir::product()) {
            Response::response(Response::HTTP_INTERNAL_SERVER_ERROR, '服务器错误，请稍后重试');
            return;
        }

        Response::response(Response::HTTP_INTERNAL_SERVER_ERROR, $html);
    }
}