<?php
namespace app\common\plugin\pay\driver;

use app\common\plugin\Pay;
use app\common\plugin\pay\Driver;

/**
 * 支付宝
 */
class Alipay extends Pay implements Driver
{
    public function driverParam()
    {
        return [
            'alipay_account' => '支付宝帐户',
            'alipay_partner' => '合作身份者id',
            'alipay_key' => '安全检验码',
            'alipay_appid' => '支付宝appid',
            'alipay_rsaPrivateKey' => '商户私钥(可填写路径)',
            'alipay_alipayrsaPublicKey' => '支付宝公钥(可填写路径)',
        ];
    }

    public function driverInfo()
    {
        return [
            'driver_name' => '支付宝驱动',
            'driver_class' => 'Alipay',
            'driver_describe' => '支付宝支付',
            'author' => 'Xu',
            'version' => '1.0'
        ];
    }

    public function config()
    {
        //
    }

    public function getOrderSn()
    {
        //
    }

    public function notify()
    {
        //
    }

    public function pay($order, $type = 'web')
    {
        if ($type == 'web') {
            //
        } elseif ($type == 'app') {
            //
        } else {
            //
        }
    }
}
