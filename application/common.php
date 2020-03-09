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
// Api返回数据
use think\Collection;

function api_result($code, $msg, $data = [], $header = [], $options = [])
{
    $result = [
        'code' => $code,
        'message' => $msg,
        'data' => $data,
    ];
    return Response::create($result, 'json', 200, $header, $options);
}

// 转化树状图
function get_tree($data, $parentId = 0)
{
    $result = [];
    foreach ($data as $row) {
        if ($row['parent_id'] == $parentId) {
            $children = get_tree($data, $row['id']);
            $row['children'] = $children;
            $result[] = $row;
        }
    }
    return $result;
}

// 是否为空
function is_empty($data)
{
    if ($data instanceof Collection) {
        return $data->isEmpty();
    }
    return empty($data);
}

// 获取字段列表
function get_column($input, $column_key = 'id', $index_key = null)
{
    if ($input instanceof \think\Collection) {
        $input = $input->toArray();
    }
    return array_column($input, $column_key, $index_key);
}

// 获取文件路径
function file_path($path)
{
    return url(config('custom.upload_path') . '/' . $path, '', false, true);
}