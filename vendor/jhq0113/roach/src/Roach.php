<?php
namespace roach;

/**
 * Class Roach
 * @package roach
 * @datetime 2020/7/1 4:50 下午
 * @author   roach
 * @email    jhq0113@163.com
 */
class Roach
{
    /**
     * Roach constructor.
     * @param array $config
     * @throws \ReflectionException
     */
    public function __construct($config = [])
    {
        Container::assem($this, $config);
    }
}