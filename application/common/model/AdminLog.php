<?php
namespace app\common\model;

class AdminLog extends Base
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    public function getIpAttr($value)
    {
        return long2ip($value);
    }

    public function user()
    {
        return $this->belongsTo('Admin', 'user_id');
    }

    public function menu()
    {
        return $this->belongsTo('AdminMenu', 'url', 'url');
    }

    public static function saveLog($uid, $url, $name = '')
    {
        if (!$name) {
            $name = AdminMenu::getTitle($url);
        }
        return self::saveData([
            'user_id' => $uid,
            'name' => $name,
            'url' => $url,
            'ip' => request()->ip(1),
        ]);
    }
}
