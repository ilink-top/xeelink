<?php
namespace app\common\model;

use think\facade\Env;
use think\Loader;

class SystemPlugin extends Base
{
    protected $autoWriteTimestamp = true;
    protected $auto = ['status'];

    public $statusData = [
        0 => '禁用',
        1 => '启用',
    ];

    public function scopeStatus($query)
    {
        $query->where('status', 1);
    }

    public function setConfigAttr($value)
    {
        return json_encode($value);
    }

    public function setStatusAttr($value)
    {
        return $value ?: 0;
    }

    public function getConfigAttr($value)
    {
        return json_decode($value, true);
    }

    public function getStatusTextAttr($value, $data)
    {
        return $data['status'] ? '<span class="badge bg-green">' . $this->$statusData[$data['status']] . '</span>' : '<span class="badge bg-red">' . $this->$statusData[$data['status']] . '</span>';
    }

    public static function driver($where)
    {
        return self::getInstance()
            ->where($where)
            ->column('driver_name', 'driver');
    }

    public static function uninstall($type, $driver)
    {
        $where = [
            ['type', '=', $type],
            ['driver', '=', $driver],
        ];
        return self::deleteData(function ($query) use ($where) {
            $query->where($where);
        });
    }

    private static function getPluginPath()
    {
        return Env::get('app_path') . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR;
    }

    public static function getType()
    {
        $file_list = file_list(self::getPluginPath(), false);
        $list = [];
        foreach ($file_list as $file) {
            $info = pathinfo($file['url']);
            $name = $info['filename'];
            if (strpos($name, 'Base') === false) {
                $res = self::getTypeInfo($name);
                if ($res['is_show']) {
                    $list[$name] = $res;
                }
            }
        }
        return arraytolower($list);
    }

    public static function getDriver($type)
    {
        $file_list = file_list(self::getPluginPath() . $type . DIRECTORY_SEPARATOR . 'driver' . DIRECTORY_SEPARATOR);
        $list = [];
        foreach ($file_list as $file) {
            $info = pathinfo($file['url']);
            $name = $info['filename'];
            if (strpos($name, 'Base') === false) {
                $list[$name] = self::getDriverInfo($name, $type);
            }
        }
        return arraytolower($list);
    }

    public static function getTypeInfo($name)
    {
        return Loader::factory($name, 'app\\common\\plugin\\')->typeInfo();
    }

    public static function getDriverInfo($name, $type)
    {
        return Loader::factory($name, 'app\\common\\plugin\\' . $type . '\\driver\\')->driverInfo();
    }

    public static function getDriverParam($name, $type)
    {
        return Loader::factory($name, 'app\\common\\plugin\\' . $type . '\\driver\\')->driverParam();
    }
}
