<?php
namespace app\common\plugin\storage;

use app\common\plugin\BaseInterface;

/**
 * 云存储插件驱动
 */
interface Driver extends BaseInterface
{
    /**
     * 获取驱动参数
     */
    public function driverParam();

    /**
     * 获取基本信息
     */
    public function driverInfo();

    /**
     * 上传图片
     */
    public function uploadImage($file, $path);

    /**
     * 上传文件
     */
    public function uploadFile($file, $path);

    /**
     * 删除图片
     */
    public function deleteImage($file);

    /**
     * 删除文件
     */
    public function deleteFile($file);
}
