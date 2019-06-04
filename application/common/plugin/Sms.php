<?php
namespace app\common\plugin;

/**
 * 短信插件
 */
class Sms extends Base implements BaseInterface
{
    public function typeInfo()
    {
        return [
            'type_name' => '短信插件',
            'type_class' => 'Sms',
            'type_describe' => '系统短信插件，用于整合多个短信平台',
            'author' => 'Xu',
            'version' => '1.0',
            'is_show' => 0
        ];
    }
}
