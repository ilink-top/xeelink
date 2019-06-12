<?php
namespace app\common\model;

class Admin extends Base
{
    protected $autoWriteTimestamp = true;
    protected $insert = ['create_ip'];

    public function setCreateIpAttr($value)
    {
        return request()->ip(1);
    }

    public function getNameAttr($value, $data)
    {
        return $data['nickname'] ? $data['nickname'] : $data['username'];
    }

    public function getLoginIpAttr($value)
    {
        return long2ip($value);
    }

    public function getLoginTimeAttr($value)
    {
        return $this->formatDateTime($this->dateFormat, $value, true);
    }

    public function getCreateIpAttr($value)
    {
        return long2ip($value);
    }

    public function auth()
    {
        return $this->belongsToMany('AdminAuth', 'AdminAuthAccess', 'auth_id', 'user_id');
    }

    public static function saveData($data, $where = [])
    {
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }
        return parent::saveData($data, $where);
    }

    public static function saveProfile($param)
    {
        unset($param['username']);
        return self::saveData($param);
    }

    public static function deleteData($id)
    {
        $id = stringtoarray($id);
        $admin_id = stringtoarray(config('auth.admin_id'));
        if (array_intersect($id, $admin_id)) {
            self::error('超级管理员不可删除');
        }

        return self::transaction(function () use ($id) {
            parent::deleteData($id);
            AdminAuthAccess::where('user_id', 'in', $id)->delete();
        });
    }

    public static function saveAuth($id, $auth_ids)
    {
        $auth = self::get($id)->auth();

        self::transaction(function () use ($auth, $auth_ids) {
            $auth->detach();
            if (!empty($auth_ids)) {
                $auth->attach($auth_ids);
            }
        });
    }

    public static function lastLogin($limit = 10)
    {
        return self::getPage([], 'login_time desc', '*', $limit);
    }

    public static function login($username, $password)
    {
        $user = self::get([
            'username' => $username,
        ]);

        if (empty($user)) {
            self::error('账户不存在');
        }

        if (!bcrypt($password, $user['password'])) {
            self::error('密码错误');
        }

        $result = self::saveData([
            'id' => $user->id,
            'login_ip' => request()->ip(1),
            'login_time' => time(),
        ]);
        if ($result !== true) {
            self::error('登录失败');
        }

        return $user;
    }
}
