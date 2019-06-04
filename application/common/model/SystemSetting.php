<?php
namespace app\common\model;

class SystemSetting extends Base
{
    public static function getSetting($where = [])
    {
        return self::getInstance()
            ->where($where)
            ->order('id asc')
            ->column('value', 'name');
    }

    public static function saveSetting($data)
    {
        $setting = self::getSetting();
        foreach ($setting as $name => $value) {
            // switch未选中的设为0
            if (!isset($data[$name])) {
                $data[$name] = 0;
            }
        }
        foreach ($data as $name => $value) {
            $result = self::saveData([
                'value' => $value
            ], [
                'name' => $name
            ]);
            if (!$result) {
                return false;
            }
        }
        return true;
    }
}