<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/23
 * Time: 4:48 PM
 */

namespace console\modules\v1;

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
     * @var string
     * @datetime 2020/7/23 4:48 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public $id = 'v1';

    public function before()
    {
        echo $this->id;
        return true;
    }

    public function after($result)
    {
        exit($result);
    }
}