<?php
namespace app\model;

use think\model\concern\SoftDelete;
use think\model\Collection;

class AdminUser extends Base
{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $hidden = ['password', 'create_time', 'update_time', 'delete_time'];
    protected $append = ['role_ids'];

    public function getRoleIdsAttr()
    {
        return get_column($this->role()->select());
    }

    public function getMenu()
    {
        $menuList = new Collection();
        foreach ($this->role as $role) {
            $menuList = $menuList->merge($role->menu()->order('sort_order')->select());
        }

        return $menuList;
    }

    public function getShowMenu()
    {
        $menuList = new Collection();
        foreach ($this->role as $role) {
            $menuList = $menuList->merge($role->menu()->scope('show')->order('sort_order')->select());
        }

        return $menuList;
    }

    public function role()
    {
        return $this->belongsToMany(AdminRole::class, 'AdminUserRole', 'role_id', 'user_id');
    }

    public function dept()
    {
        return $this->belongsToMany(AdminDepartment::class, 'AdminDepartmentLeader', 'dept_id', 'user_id');
    }

    public static function getMap($param = [])
    {
        $map = [];

        if (!empty($param['id'])) {
            $map[] = ['id', '=', $param['id']];
        }
        if (!empty($param['dept_id'])) {
            $map[] = ['dept_id', '=', $param['dept_id']];
        }
        if (!empty($param['user_name'])) {
            $map[] = ['user_name', 'like', '%' . $param['user_name'] . '%'];
        }
        if (!empty($param['sex'])) {
            $map[] = ['sex', '=', $param['sex']];
        }
        if (!empty($param['email'])) {
            $map[] = ['email', 'like', '%' . $param['email'] . '%'];
        }
        if (!empty($param['mobile'])) {
            $map[] = ['mobile', 'like', '%' . $param['mobile'] . '%'];
        }
        if (!empty($param['status'])) {
            $map[] = ['status', '=', $param['status']];
        }
        if (!empty($param['start_date'])) {
            $map[] = ['create_time', '>=', strtotime($param['start_date'])];
        }
        if (!empty($param['end_date'])) {
            $map[] = ['create_time', '<=', strtotime($param['end_date'])];
        }

        return $map;
    }

    public static function create($data = [], $field = null, $replace = false)
    {
        return self::transaction(function () use ($data, $field, $replace) {
            if (!empty($data['password'])) {
                $data['password'] = app('hash')->make($data['password']);
            } else {
                unset($data['password']);
            }
            $result = parent::create($data, $field, $replace);
            if (!empty($data['role_ids'])) {
                $result->role()->sync($data['role_ids']);
            }
            return $result;
        });
    }

    public static function update($data = [], $where = [], $field = null)
    {
        return self::transaction(function () use ($data, $where, $field) {
            if (!empty($data['password'])) {
                $data['password'] = app('hash')->make($data['password']);
            } else {
                unset($data['password']);
            }
            $result = parent::update($data, $where, $field);
            if (!empty($data['role_ids'])) {
                $result->role()->sync($data['role_ids']);
            }
            return $result;
        });
    }

    public static function destroy($data)
    {
        return self::transaction(function () use ($data) {
            $list = self::all($data);
            foreach ($list as $row) {
                $row->role()->detach();
                $row->dept()->detach();
                $row->delete();
            }
            return true;
        });
    }
}
