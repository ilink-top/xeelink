<?php
namespace app\common\plugin;

/**
 * 基础插件
 */
class Base
{
    protected $config;

    public function __construct($config = [])
    {
        $this->config = $config;
    }
}
