<?php
use think\Container;
use think\facade\Config;
use think\facade\Request;

function file_list($path, $map = true, $allowFiles = '', &$files = array())
{
    if (!is_dir($path)) {
        return null;
    }

    if (substr($path, strlen($path) - 1) != '/') {
        $path .= '/';
    }

    $handle = opendir($path);
    while (false !== ($file = readdir($handle))) {
        if ($file != '.' && $file != '..') {
            $path2 = $path . $file;
            if (is_dir($path2)) {
                if ($map) {
                    file_list($path2, $map, $allowFiles, $files);
                }
            } else {
                if (empty($allowFiles) || !preg_match("/\.(" . $allowFiles . ")$/i", $file)) {
                    $files[] = array(
                        'url' => substr($path2, strlen($_SERVER['DOCUMENT_ROOT'])),
                        'mtime' => filemtime($path2),
                    );
                }
            }
        }
    }
    return $files;
}

function upload_file($name, $path, $validate = [])
{
    try {
        $file = Request::file($name);
    } catch (\Exception $e) {
        exception('文件非法');
    }
    if (empty($file)) {
        exception('文件非法');
    }

    if (isset($validate['size']) && empty($validate['size'])) {
        unset($validate['size']);
    }
    if (isset($validate['ext'])) {
        $validate['ext'] = stringtoarray($validate['ext']);
        foreach ($validate['ext'] as $key => $value) {
            $validate['ext'][$key] = trim($value, '.');
        }
    }
    $info = $file->validate($validate)->move($path);
    if (!$info) {
        exception($file->getError());
    }
    $result = $info;
    unset($info);

    $storage = plugin('storage');
    if ($storage) {
        $result = $storage->uploadPicture($result->getSaveName(), $path);
    }

    return $result;
}

function delete_file($name)
{
    $storage = plugin('storage');
    if ($storage) {
        return $storage->deletePicture($name);
    }
    return unlink(config('plugin.storage.upload_path') . $name);
}

function thumb($name, $width, $height)
{
    if (!$name) {
        return $name;
    }
    $info = pathinfo($name);
    $newname = $info['dirname'] . $info['filename'] . '_' . $width . '_' . $height . '.' . $info['extension'];
    if (file_exists(Config::get('file.imagePath') . $newname)) {
        return $newname;
    }

    //1.打开图片源文件资源
    $im = imagecreatefromjpeg(Config::get('file.imagePath') . $name);

    //2.获得源文件的宽高
    $fx = imagesx($im); // 获取宽度
    $fy = imagesy($im); // 获取高度

    //3.使用固定的公式计算新的宽高
    $sx = $width;
    $sy = $height;

    //4.生成目标图像资源
    $small = imagecreatetruecolor($sx, $sy);

    //5.进行缩放
    imagecopyresampled($small, $im, 0, 0, 0, 0, $sx, $sy, $fx, $fy);

    //6.保存图像
    $result = imagejpeg($small, Config::get('file.imagePath') . $newname);

    //7.释放资源
    imagedestroy($im);
    imagedestroy($small);

    return $result ? $newname : '';
}

// 获取图片地址
function image_url($name = '', $width = 0, $height = 0)
{
    if ($width && $height) {
        $name = thumb($name, $width, $height);
    }
    return file_url($name, 'image');
}

// 获取视频地址
function video_url($name = '')
{
    return file_url($name, 'video');
}

// 获取文件地址
function file_url($name = '', $type = '')
{
    $request = Container::get('request');
    $parse = parse_url($name);
    if (isset($parse['host']) && $parse['host'] != $request->host()) {
        return $name;
    }
    switch ($type) {
        case 'image':
            $prefix = Config::get('file.imageUrlPrefix');
            break;

        case 'video':
            $prefix = Config::get('file.videoUrlPrefix');
            break;

        default:
            $prefix = Config::get('file.fileUrlPrefix');
            break;
    }
    return $prefix . $name;
}

// 文件大小
function file_size($bytes, $decimals = 2)
{
    $sz = ['B', 'K', 'M', 'G', 'T', 'P'];
    $factor = intval(floor((strlen($bytes) - 1) / 3));
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $sz[$factor];
}

function file_size_format($size)
{
    $sz = ['B', 'K', 'M', 'G', 'T', 'P'];
    $factor = (int) array_search(substr($size, -1), $sz);
    return intval($size) * pow(1024, $factor);

}