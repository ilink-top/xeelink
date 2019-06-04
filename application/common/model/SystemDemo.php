<?php
namespace app\common\model;

use think\model\concern\SoftDelete;

class SystemDemo extends Base
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

    public function getStatusTextAttr($value, $data)
    {
        return $data['status'] ? '<span class="badge bg-green">' . $this->statusData[$data['status']] . '</span>' : '<span class="badge bg-red">' . $this->statusData[$data['status']] . '</span>';
    }
}
