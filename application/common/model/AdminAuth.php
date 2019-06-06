<?php
namespace app\common\model;

class AdminAuth extends Base
{
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

    public function user()
    {
        return $this->belongsToMany('Admin', 'AdminAuthAccess', 'user_id', 'auth_id');
    }

    public function menu()
    {
        return $this->belongsToMany('AdminMenu', 'AdminAuthMenu', 'menu_id', 'auth_id');
    }

    public static function deleteData($id)
    {
        return self::transaction(function () use ($id) {
            parent::deleteData($id);
            AdminAuthAccess::where('auth_id', 'in', $id)->delete();
            AdminAuthMenu::where('auth_id', 'in', $id)->delete();
        });
    }

    public static function saveMenu($id, $menu_ids)
    {
        $menu = self::get($id)->menu();
        self::transaction(function () use ($menu, $menu_ids) {
            $menu->detach();
            if (!empty($menu_ids)) {
                $menu->attach($menu_ids);
            }
        });
    }
}
