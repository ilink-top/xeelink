<?php
namespace app\common\plugin;

/**
 * 支付插件
 */
class Pay extends Base implements BaseInterface
{
    const NOTIFY_URL    = 'http://xxx/payment/notify';
    const CALLBACK_URL  = 'http://xxx/payment/notify';

    public function typeInfo()
    {
        return [
            'type_name' => '支付插件',
            'type_class' => 'Pay',
            'type_describe' => '系统支付插件，用于整合多个支付平台',
            'author' => 'Xu',
            'version' => '1.0',
            'is_show' => 1
        ];
    }
}
