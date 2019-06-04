<?php
namespace app\common\plugin\pay\driver;

use app\common\plugin\Pay;
use app\common\plugin\pay\Driver;

/**
 * 微信支付
 */
class Wechatpay extends Pay implements Driver
{
    public function driverParam()
    {
        return [
            'appid' => 'appid 微信公众号唯一标识',
            'appsecret' => 'appsecret',
            'partnerid' => '受理商ID（商户号）',
            'partnerkey' => '商户支付密钥Key',
        ];
    }

    public function driverInfo()
    {
        return [
            'driver_name' => '微信支付驱动',
            'driver_class' => 'Wechatpay',
            'driver_describe' => '微信支付',
            'author' => 'Xu',
            'version' => '1.0',
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

    public function pay($order = [], $type = 'web')
    {
        switch ($type) {
            case 'app':
                //
                break;
            case 'web':
                //
                break;
            case 'h5':
                //
                break;
            case 'JSAPI':
                //
                break;
            default:
                //补充...
                break;
        }
    }
}
