<?php
use app\common\model\SystemArea;
use app\common\model\SystemPlugin;
use app\common\model\SystemSetting;
use think\facade\Config;
use think\Loader;

// 驱动
function plugin($type, $driver = '')
{
    $driver = $driver ?: Config::get('plugin.' . $type . '.driver');
    if (!$driver) {
        return false;
    }
    $info = SystemPlugin::get([
        'type' => $type,
        'driver' => $driver,
    ]);
    return Loader::factory(ucwords($driver), 'app\\common\\plugin\\' . $type . '\\driver\\', $info->config);
}

// 地区数据
function areadata($parent_id = 0)
{
    return SystemArea::where('parent_id', $parent_id)->order('sort asc')->column('area_id, area_name');
}

// 系统设置
function setting($name = null, $default = null)
{
    $config = Config::pull('setting');
    $setting = SystemSetting::getSetting();
    $data = array_merge($config, $setting);
    if (empty($name)) {
        return $data;
    }
    if (isset($data[$name])) {
        return $data[$name];
    } else {
        return $default;
    }
}