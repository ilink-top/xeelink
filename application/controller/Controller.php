<?php
namespace app\controller;

use think\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * 获取当前请求的参数
     * @access public
     * @param  mixed         $name 变量名
     * @param  mixed         $default 默认值
     * @param  string|array  $filter 过滤方法
     * @return mixed
     */
    protected function param($name = '', $default = null, $filter = '')
    {
        return $this->request->param($name, $default, $filter);
    }

    /**
     * 验证数据
     * @access protected
     * @param  array        $data     数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @param  array        $message  提示信息
     * @param  bool         $batch    是否批量验证
     * @param  mixed        $callback 回调方法（闭包）
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validateResult($data, $validate, $message = [], $batch = false, $callback = null)
    {
        $result = parent::validate($data, $validate, $message, $batch, $callback);
        if ($result !== true) {
            return $this->error($result);
        }
    }
}
