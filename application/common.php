<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\facade\Env;
$path = Env::get('app_path') . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR;
$handle = opendir($path);
while (false !== ($file = readdir($handle))) {
    if ($file != "." && $file != ".." && !is_dir($file)) {
        include $path . $file;
    }
}