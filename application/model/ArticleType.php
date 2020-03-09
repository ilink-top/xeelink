<?php
namespace app\model;

use think\model\concern\SoftDelete;

class ArticleType extends Base
{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $hidden = ['create_time', 'update_time', 'delete_time'];

    public static function destroy($data)
    {
        $list = self::all($data);
        $childrenCount = self::where('parent_id', 'in', get_column($list))->count();

        if ($childrenCount > 0) {
            self::instance()->error = '有下级数据不可删除';
            return false;
        }

        return parent::destroy($data);
    }
}
