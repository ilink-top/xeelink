<?php
namespace app\model;

use think\model\concern\SoftDelete;

class AdminMenu extends Base
{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $hidden = ['create_time', 'update_time', 'delete_time'];

    public static function init()
    {
        //新增菜单时默认给超级管理员角色加入菜单权限
        self::event('after_insert', function ($menu) {
            $permissionIds = array_column(AdminMenu::field('id')->select()->toArray(),'id');
            $roleInfo = AdminRole::find(AdminRole::ADMIN_ROLE_ID);
            $roleInfo->menu()->sync($permissionIds);
            return true;
        });
    }

    public function scopeShow()
    {
        return $this->where('type', 1);
    }

    public function role()
    {
        return $this->belongsToMany(AdminRole::class, 'AdminRoleMenu', 'role_id', 'menu_id');
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
                $row->role()->detach();
                $row->delete();
            }
            return true;
        });
    }
}
