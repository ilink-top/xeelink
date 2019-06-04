<?php
use think\helper\Hash;
use think\facade\Config;

// 数据签名认证
function data_auth_sign($data)
{
    // 数据类型检测
    if (!is_array($data)) {
        $data = (array) $data;
    }
    // 排序
    ksort($data);
    // url编码并生成query字符串
    $code = http_build_query($data);
    // 生成签名
    $sign = sha1($code);
    return $sign;
}

// 数组转小写
function arraytolower($data)
{
    $data = serialize($data);
    $data = strtolower($data);
    $data = unserialize($data);
    return $data;
}

// 字符串转数组
function stringtoarray($data)
{
    if (empty($data)) {
        return [];
    }
    if (is_string($data) || is_numeric($data)) {
        if (strpos($data, ',') !== false) {
            $data = explode(',', $data);
        } else {
            $data = [$data];
        }
    }
    return $data;
}

// 数组转字符串
function arraytostring($data)
{
    if (is_array($data)) {
        $data = implode(',', $data);
    }
    return $data;
}

// 重复字符串
function string_repeat($string = '', $times = 0)
{
    $result = '';
    for ($i = 0; $i < $times; $i++) {
        $result .= $string;
    }
    return $result;
}

// 合并对象
function object_merge()
{
    foreach (func_get_args() as $a) {
        $objects[] = (array) $a;
    }
    return (object) call_user_func_array('array_merge', $objects);
}

// 生成/检验密码
function bcrypt($value, $hashedValue = '')
{
    return $hashedValue ? Hash::check($value, $hashedValue, 'bcrypt') : Hash::make($value, 'bcrypt');
}

// 生成树形
function tree($list, $parent_id = 0)
{
    $tree = [];
    foreach ($list as $row) {
        if ($row['parent_id'] == $parent_id) {
            $sub = tree($list, $row['id']);
            if (!empty($sub)) {
                $row['sub'] = $sub;
            }
            $tree[] = $row;
        }
    }
    return $tree;
}

// 生成树形列表
function tree_list($list, $parent_id = 0, $level = 0)
{
    $result = [];
    foreach ($list as $row) {
        if ($row['parent_id'] == $parent_id) {
            $row['title'] = $row['title'];
            $row['level'] = $level;
            $result[] = $row;
            $result = array_merge($result, tree_list($list, $row['id'], $level + 1));
        }
    }
    return $result;
}

// 判断一维数组
function is_single_array($data)
{
    return is_array($data) && count($data) == count($data, COUNT_RECURSIVE);
}

// 判断索引数组
function is_index_array($data)
{
    return is_array($data) && array_keys($data) === range(0, count($data) - 1);
}

// 随机md5字符串
function md5_random()
{
    return md5(uniqid(mt_rand(), true));
}

// 获取datetime-local格式时间
function datetime_local($time)
{
    return date('Y-m-d', $time) . 'T' . date('H:i:s', $time);
}

// 获取模块/控制器/行为
function path($path = '')
{
    if (!$path) {
        $path = request()->path();
    }
    $path_arr = explode('/', $path);
    return [
        'module' => isset($path_arr[0]) ? $path_arr[0] : Config::get('default_module'),
        'controller' => isset($path_arr[1]) ? $path_arr[1] : Config::get('default_controller'),
        'action' => isset($path_arr[2]) ? $path_arr[2] : Config::get('default_action'),
    ];
}

// 分页信息
function pageinfo($list)
{
    $currentPage = $list->currentPage();
    $listRows = $list->listRows();
    $total = $list->total();
    $start = ($currentPage - 1) * $listRows + 1;
    $end = min($currentPage * $listRows, $total);
    return "显示第 {$start} 至 {$end} 项结果，共 {$total} 项";
}