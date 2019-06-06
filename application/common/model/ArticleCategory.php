<?php
namespace app\common\model;

use think\model\concern\SoftDelete;

class ArticleCategory extends Base
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;
    protected $autoWriteTimestamp = true;

    public function article()
    {
        return $this->hasMany('Article', 'category_id');
    }

    public static function deleteData($id)
    {
        $disableCount = self::getInstance()
            ->where('parent_id', 'in', $id)
            ->where('id', 'not in', $id)
            ->count();
        if ($disableCount > 0) {
            self::error('有子选项不可删除');
        }

        return parent::deleteData($id);
    }
}
