<?php
namespace app\common\plugin\pay;

use app\common\plugin\BaseInterface;

/**
 * 支付插件驱动
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
     * 支付通知
     */
    public function notify();

    /**
     * 获取订单号
     */
    public function getOrderSn();

    /**
     * 支付
     */
    public function pay($order);
}
