<?php
namespace app\common\plugin\storage\driver;

use app\common\plugin\storage\Driver;
use app\common\plugin\Storage;
// composer: aliyuncs/oss-sdk-php
use OSS\OssClient;

/**
 * 阿里云OSS
 */
class Aliyun extends Storage implements Driver
{
    public function driverInfo()
    {
        return [
            'driver_name' => '阿里云OSS驱动',
            'driver_class' => 'Aliyun',
            'driver_describe' => '阿里云存储',
            'author' => 'Xu',
            'version' => '1.0'
        ];
    }

    public function driverParam()
    {
        return [
            'ak_id' => '阿里云accessKeyId',
            'ak_secret' => '阿里云accessKeySecret',
            'bucket_name' => '阿里云bucket',
            'endpoint' => '阿里云endpoint'
        ];
    }

    public function uploadImage($file, $path)
    {
        return $this->uploadFile($file);
    }

    public function uploadFile($file, $path)
    {
        $config = $this->config;
        $client = new OssClient($config['ak_id'], $config['ak_secret'], $config['endpoint']);
        $file_path = $path . $file;
        $client->uploadFile($config['bucket_name'], $file, $file_path);
        unlink($file_path);

        return $file;
    }

    public function deleteImage($file)
    {
        return $this->deleteFile($file);
    }

    public function deleteFile($file)
    {
        $config = $this->config;
        $client = new OssClient($config['ak_id'], $config['ak_secret'], $config['endpoint']);

        return $client->deleteObject($config['bucket_name'], $file);
    }
}
