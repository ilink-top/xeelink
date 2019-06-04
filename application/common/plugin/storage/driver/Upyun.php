<?php
namespace app\common\plugin\storage\driver;

use app\common\plugin\storage\Driver;
use app\common\plugin\Storage;

/**
 * 又拍云
 */
class Upyun extends Storage implements Driver
{
    public function driverInfo()
    {
        return [
            'driver_name' => '又拍云驱动',
            'driver_class' => 'Upyun',
            'driver_describe' => '又拍云存储',
            'author' => 'Xu',
            'version' => '1.0'
        ];
    }

    public function driverParam()
    {
        return [
        ];
    }

    public function config()
    {
        return $this->driverConfig();
    }

    public function uploadImage($file, $path)
    {
        //
    }

    public function uploadFile($file, $path)
    {
        //
    }

    public function deleteImage($file)
    {
        //
    }

    public function deleteFile($file)
    {
        //
    }
}
