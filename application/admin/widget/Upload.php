<?php
namespace app\admin\widget;

class Upload extends Base
{
    private $config;
    public function __construct()
    {
        parent::__construct();
        $this->config = config('file.');
    }

    public function image($name, $value = '')
    {
        $ext = $this->config['imageAllowFiles'];
        $this->assign([
            'name' => $name,
            'value' => $value,
            'ext' => $ext,
            'md5' => md5_random(),
        ]);
        return $this->fetch('widget/upload/image');
    }

    public function images($name, $value = '')
    {
        $ext = $this->config['imageAllowFiles'];
        $value = stringtoarray($value);
        $this->assign([
            'name' => $name,
            'value' => $value,
            'ext' => $ext,
            'md5' => md5_random(),
        ]);
        return $this->fetch('widget/upload/images');
    }

    public function file($name, $value = '')
    {
        $ext = $this->config['fileAllowFiles'];
        $this->assign([
            'name' => $name,
            'value' => $value,
            'ext' => $ext,
            'md5' => md5_random(),
        ]);
        return $this->fetch('widget/upload/file');
    }

    public function files($name, $value = '')
    {
        $ext = $this->config['fileAllowFiles'];
        $value = stringtoarray($value);
        $this->assign([
            'name' => $name,
            'value' => $value,
            'ext' => $ext,
            'md5' => md5_random(),
        ]);
        return $this->fetch('widget/upload/files');
    }
}
