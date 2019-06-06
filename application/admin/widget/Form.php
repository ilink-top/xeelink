<?php
namespace app\admin\widget;

class Form extends Base
{
    public function editor($name)
    {
        $this->assign([
            'name' => $name,
            'md5' => md5_random(),
        ]);
        return $this->fetch('widget/form/editor');
    }

    public function area($name = [], $value = [])
    {
        if (empty($name['province'])) {
            $name['province'] = 'province_id';
        }
        if (empty($name['city'])) {
            $name['city'] = 'city_id';
        }
        if (empty($name['district'])) {
            $name['district'] = 'district_id';
        }
        $data['province'] = $this->app->action('system_area/data');
        if (isset($value['province']) && $value['province']) {
            $data['city'] = areadata($value['province']);
        } else {
            $data['city'] = [];
        }
        if (isset($value['city']) && $value['city']) {
            $data['district'] = areadata($value['city']);
        } else {
            $data['district'] = [];
        }
        $this->assign([
            'name' => $name,
            'value' => $value,
            'data' => $data,
            'md5' => md5_random(),
        ]);
        return $this->fetch('widget/form/area');
    }

    public function table($name, $value = [])
    {
        $this->assign([
            'name' => $name,
            'value' => $value,
            'md5' => md5_random(),
        ]);
        return $this->fetch('widget/form/table');
    }
}
