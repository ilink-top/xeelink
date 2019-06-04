<?php
namespace app\common\plugin\sms;

use app\common\plugin\BaseInterface;

/**
 * 短信插件驱动
 */
interface Driver extends BaseInterface
{

    /**
     * 获取驱动参数
     */
    public function driverParam();

    /**
     * 获取基本信息
     */
    public function driverInfo();

    /**
     * 配置信息
     */
    public function config();

    /**
     * 发送短信
     */
    public function sendSms($parameter);
}
