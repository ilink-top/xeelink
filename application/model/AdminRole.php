<?php
namespace app\model;

use think\model\concern\SoftDelete;

class AdminRole extends Base
{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $hidden = ['create_time', 'update_time', 'delete_time'];
    const ADMIN_ROLE_ID = 1;

    public function user()
    {
        return $this->belongsToMany(AdminUser::class, 'AdminUserRole', 'user_id', 'role_id');
    }

    public function menu()
    {
        return $this->belongsToMany(AdminMenu::class, 'AdminRoleMenu', 'menu_id', 'role_id');
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
        return self::transaction(function () use ($data) {
            $list = self::all($data);
            foreach ($list as $row) {
                $row->menu()->detach();
                $row->user()->detach();
                $row->delete();
            }
            return true;
        });
    }
}
