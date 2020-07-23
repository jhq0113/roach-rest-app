<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/23
 * Time: 3:20 PM
 */
namespace common\extensions;

use roach\extensions\IExtension;

/**
 * Class EArray
 * @package common\extensions
 * @datetime 2020/7/23 3:20 PM
 * @author roach
 * @email jhq0113@163.com
 */
class EArray extends IExtension
{
    /**
     * @param array $array1
     * @param array $array2
     * @param array $arrayN
     * @return array|mixed
     * @datetime 2020/7/23 3:21 PM
     * @author roach
     * @email jhq0113@163.com
     */
    static public function merge($array1, $array2)
    {
        $args = func_get_args();
        $result = array_shift($args);

        while (!empty($args)) {
            $next = array_shift($args);
            foreach ($next as $k => $v) {
                if (is_int($k)) {
                    if (array_key_exists($k, $result)) {
                        $result[] = $v;
                    } else {
                        $result[$k] = $v;
                    }
                } elseif (is_array($v) && isset($result[$k]) && is_array($result[$k])) {
                    $result[$k] = self::merge($result[$k], $v);
                } else {
                    $result[$k] = $v;
                }
            }
        }

        return $result;
    }
}