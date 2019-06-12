<?php
namespace app\common\model;

use think\facade\Request;
use think\facade\Session;

class Auth extends Base
{
    // 权限设置
    protected $config = [
        // 权限开关
        'auth_on' => 1,
        // 认证方式，1为实时认证；2为登录认证。
        'auth_type' => 1,
        // 用户组数据表名
        'auth_group' => 'auth_group',
        // 权限规则表
        'auth_rule' => 'auth_rule',
        // 用户信息表
        'auth_user' => 'auth_user',
        // 超级管理员ID
        'admin_id' => 0,
        // Session名
        'session_name' => 'user_id',
    ];

    public function __construct($config = [])
    {
        parent::__construct();
        $this->config = array_merge($this->config, $config);
    }

    /**
     * 检查权限
     * @param string|array $name 需要验证的规则列表,支持逗号分隔的权限规则或索引数组
     * @param int $uid 认证用户的id
     * @param int $type 认证类型
     * @param string $mode 执行check的模式
     * @param string $relation 如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
     * @return bool 通过验证返回true;失败返回false
     */
    public function check($name, $uid, $type = 1, $mode = 'url', $relation = 'or')
    {
        // 权限验证关闭
        if (!$this->config['auth_on']) {
            return true;
        }
        // 是超级管理员
        if ($this->isAdmin($uid)) {
            return true;
        }
        $name = arraytolower(stringtoarray($name));
        $list = $this->checkAuthList($name, $uid, $type, $mode);
        if ('or' == $relation && !empty($list)) {
            return true;
        }
        $diff = array_diff($name, $list);
        if ('and' == $relation && empty($diff)) {
            return true;
        }
        return false;
    }

    /**
     * 获取用户需要验证的所有有效规则列表
     * @param string|array $url 需要验证的规则列表,支持逗号分隔的权限规则或索引数组
     * @param int $uid 用户id
     * @param int $type 认证类型
     * @param string $mode 执行check的模式
     * @return list 有效规则列表
     */
    public function checkAuthList($url, $uid, $type = 1, $mode = 'url')
    {
        $list = [];
        $url = arraytolower(stringtoarray($url));
        $authList = $this->getAuthList($uid, $type);
        foreach ($authList as $auth) {
            $query = preg_replace('/^.+\?/U', '', $auth);
            if ('url' == $mode && $query != $auth) {
                parse_str($query, $param); //解析规则中的param
                $intersect = array_intersect_assoc(arraytolower(Request::param()), $param);
                $auth = preg_replace('/\?.*$/U', '', $auth);
                if (in_array($auth, $url) && $intersect == $param) {
                    //如果节点相符且url参数满足
                    $list[] = $auth;
                }
            } else {
                if (in_array($auth, $url)) {
                    $list[] = $auth;
                }
            }
        }
        return $list;
    }

    /**
     * 获得权限列表
     * @param int $uid 用户id
     * @param int $type 认证类型
     * @return array
     */
    public function getAuthList($uid, $type = 1)
    {
        $_authList = []; //保存用户验证通过的权限列表
        $t = implode(',', (array) $type);
        if (isset($_authList[$uid . $t])) {
            return $_authList[$uid . $t];
        }
        if (2 == $this->config['auth_type'] && Session::has('_auth_list_' . $uid . $t)) {
            return Session::get('_auth_list_' . $uid . $t);
        }
        if ($this->isAdmin($uid)) {
            $map = [
                ['type', '=', $type],
            ];
        } else {
            $ids = $this->getAuthId($uid);
            if (empty($ids)) {
                $_authList[$uid . $t] = [];
                return [];
            }
            $map = [
                ['type', '=', $type],
                ['id', 'in', $ids],
            ];
        }
        $authList = $this->getAuthRules($uid, $map);
        $_authList[$uid . $t] = $authList;
        if (2 == $this->config['auth_type']) {
            //规则列表结果保存到session
            Session::set('_auth_list_' . $uid . $t, $authList);
        }
        return $authList;
    }

    /**
     * 用户所属用户组设置的所有权限规则id
     * @param int $uid 用户id
     * @return array 用户组设置的所有权限规则id
     */
    public function getAuthId($uid)
    {
        $auth = $this->getAuth($uid);
        $ids = []; //保存用户所属用户组设置的所有权限规则id
        foreach ($auth as $g) {
            $ids = array_merge($ids, model($this->config['auth_group'])->get($g['id'])->menu()->column('id'));
        }
        $ids = array_unique($ids);
        return $ids;
    }

    /**
     * 根据用户id获取用户组,返回值为数组
     * @param int $uid 用户id
     * @return array 用户所属的用户组 array(
     *     array('uid'=>'用户id','group_id'=>'用户组id','title'=>'用户组名称','rules'=>'用户组拥有的规则id,多个,号隔开'),
     *     ...)
     */
    public function getAuth($uid)
    {
        $auth = [];
        if (isset($auth[$uid])) {
            return $auth[$uid];
        }
        $auth[$uid] = model($this->config['auth_user'])->get($uid)->auth()->select();
        return $auth[$uid];
    }

    /**
     * 用户所属用户组设置的规则
     * @param int $uid 用户id
     * @param array $map 查询条件
     * @return array 规则
     */
    public function getAuthRules($uid, $map)
    {
        $list = [];
        //读取用户组所有权限规则
        $rules = model($this->config['auth_rule'])->scope('status')->where($map)->field('condition, url')->select();
        //循环规则，判断结果。
        foreach ($rules as $rule) {
            if (!empty($rule['condition'])) {
                //根据condition进行验证
                $user = $this->getUserInfo($uid);
                $command = preg_replace('/\{(\w*?)\}/', '$user[\'\\1\']', $rule['condition']);
                //dump($command); //debug
                @(eval('$condition=(' . $command . ');'));
                if ($condition) {
                    $list[] = strtolower($rule['url']);
                }
            } else {
                //只要存在就记录
                $list[] = strtolower($rule['url']);
            }
        }
        return $list;
    }

    /**
     * 检测当前用户是否为管理员
     * @return boolean true-管理员，false-非管理员
     */
    public function isAdmin($uid)
    {
        $admin_id = stringtoarray($this->config['admin_id']);
        return $uid && in_array($uid, $admin_id);
    }

    /**
     * 获得用户资料
     * @param int $uid 用户id
     * @return mixed
     */
    public function getUserInfo($uid)
    {
        static $user_info = [];

        $user_info[$uid] = model($this->config['auth_user'])->get($uid);

        return $user_info[$uid];
    }
}
