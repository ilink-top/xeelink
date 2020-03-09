<?php
namespace app\model;

use think\model\concern\SoftDelete;

class AdminDepartment extends Base
{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $hidden = ['create_time', 'update_time', 'delete_time'];

    public function leader()
    {
        return $this->belongsToMany(AdminUser::class, 'AdminDepartmentLeader', 'user_id', 'dept_id');
    }

    public static function getMap($param = [])
    {
        $map = [];

        if (!empty($param['id'])) {
            $map[] = ['id', '=', $param['id']];
        }
        if (!empty($param['status'])) {
            $map[] = ['status', '=', $param['status']];
        }

        return $map;
    }

    public static function update($data = [], $where = [], $field = null)
    {
        return self::transaction(function () use ($data, $where, $field) {
            $result = parent::update($data, $where, $field);
            if (!empty($data['leader'])) {
                $result->leader()->sync($data['leader']);
            }
            return $result;
        });
    }

    public static function destroy($data)
    {
        $list = self::all($data);
        $childrenCount = self::where('parent_id', 'in', get_column($list))->count();

        if ($childrenCount > 0) {
            self::instance()->error = '有下级数据不可删除';
            return false;
        }

        return self::transaction(function () use ($data) {
            $list = self::all($data);
            foreach ($list as $row) {
                $row->leader()->detach();
                $row->delete();
            }
            return true;
        });
    }
}
