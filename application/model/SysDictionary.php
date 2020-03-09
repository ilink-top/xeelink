<?php
namespace app\model;

use think\model\concern\SoftDelete;

class SysDictionary extends Base
{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $hidden = ['create_time', 'update_time', 'delete_time'];

    public static function getDictionary($where = [])
    {
        $result = [];
        $list = self::where($where)->order('sort_order')->select();
        foreach ($list as $row) {
            $result[$row['type']][] = $row;
        }
        return $result;
    }
}
