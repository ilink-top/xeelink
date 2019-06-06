<?php
namespace app\common\model;

use think\model\concern\SoftDelete;

class User extends Base
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;
    protected $autoWriteTimestamp = true;
    protected $auto = ['status'];

    public $statusData = [
        0 => '禁用',
        1 => '启用',
    ];

    public function scopeStatus($query)
    {
        $query->where('status', 1);
    }

    public function setStatusAttr($value)
    {
        return $value ?: 0;
    }

    public function getNameAttr($value, $data)
    {
        return $data['nickname'] ? $data['nickname'] : $data['username'];
    }

    public function getStatusTextAttr($value, $data)
    {
        return $data['status'] ? '<span class="badge bg-green">' . $this->statusData[$data['status']] . '</span>' : '<span class="badge bg-red">' . $this->statusData[$data['status']] . '</span>';
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
}
