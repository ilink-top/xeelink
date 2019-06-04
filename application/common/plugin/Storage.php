<?php
namespace app\common\plugin;

/**
 * 存储插件
 */
class Storage extends Base implements BaseInterface
{
    public function typeInfo()
    {
        return [
            'type_name' => '存储插件',
            'type_class' => 'Storage',
            'type_describe' => '系统存储插件，用于整合多个储存平台',
            'author' => 'Xu',
            'version' => '1.0',
            'is_show' => 1
        ];
    }
}
