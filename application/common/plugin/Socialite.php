<?php
namespace app\common\plugin;

/**
 * 社会化登录插件
 */
class Socialite extends Base implements BaseInterface
{
    public function typeInfo()
    {
        return [
            'type_name' => '社会化登录插件',
            'type_class' => 'Socialite',
            'type_describe' => '系统社会化登录插件，用于整合多个社会化登录平台',
            'author' => 'Xu',
            'version' => '1.0',
            'is_show' => 0
        ];
    }
}
