<?php
namespace app\common\plugin\storage\driver;

use app\common\plugin\storage\Driver;
use app\common\plugin\Storage;

/**
 * 七牛云
 */
class Qiniu extends Storage implements Driver
{
    public function driverInfo()
    {
        return [
            'driver_name' => '七牛云驱动',
            'driver_class' => 'Qiniu',
            'driver_describe' => '七牛云存储',
            'author' => 'Xu',
            'version' => '1.0'
        ];
    }

    public function driverParam()
    {
        return [
            'access_key' => '七牛云密钥AK',
            'secret_key' => '七牛云密钥SK',
            'bucket_name' => '上传空间名Bucket'
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
